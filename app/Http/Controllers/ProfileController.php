<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::query();

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $profiles = $query->orderBy('id', 'desc')->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'data' => $profiles->items(),
                'links' => (string) $profiles->links()
            ]);
        }

        return view('profiles.index', compact('profiles'));
    }

    public function search(Request $request)
    {
        $query = Profile::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%");
        }

        $profiles = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'data' => $profiles->items(),
            'links' => (string) $profiles->links()
        ]);
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('profile_image');

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profiles'), $imageName);
            $data['profile_image'] = $imageName;
        }

        Profile::create($data);

        return redirect('/profiles')->with('success', 'Profile added successfully!');
    }

    public function show($id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        return view('profiles.show', compact('profile'));
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $profile = Profile::findOrFail($id);
        $data = $request->except('profile_image');

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($profile->profile_image && file_exists(public_path('uploads/profiles/' . $profile->profile_image))) {
                unlink(public_path('uploads/profiles/' . $profile->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profiles'), $imageName);
            $data['profile_image'] = $imageName;
        }

        $profile->update($data);

        return redirect('/profiles')->with('success', 'Profile updated successfully!');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        
        // Delete image if exists
        if ($profile->profile_image && file_exists(public_path('uploads/profiles/' . $profile->profile_image))) {
            unlink(public_path('uploads/profiles/' . $profile->profile_image));
        }
        
        $profile->delete();

        return redirect('/profiles')->with('success', 'Profile deleted successfully!');
    }

    public function restore($id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        $profile->restore();
        
        return redirect('/profiles')->with('success', 'Profile restored successfully!');
    }

    public function forceDelete($id)
    {
        $profile = Profile::withTrashed()->findOrFail($id);
        
        // Delete image if exists
        if ($profile->profile_image && file_exists(public_path('uploads/profiles/' . $profile->profile_image))) {
            unlink(public_path('uploads/profiles/' . $profile->profile_image));
        }
        
        $profile->forceDelete();
        
        return redirect('/profiles')->with('success', 'Profile permanently deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            $profiles = Profile::whereIn('id', $ids)->get();
            
            foreach ($profiles as $profile) {
                if ($profile->profile_image && file_exists(public_path('uploads/profiles/' . $profile->profile_image))) {
                    unlink(public_path('uploads/profiles/' . $profile->profile_image));
                }
            }
            
            Profile::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Profiles deleted successfully!']);
        }
        
        return response()->json(['success' => false, 'message' => 'No profiles selected!']);
    }

    public function export()
    {
        $profiles = Profile::all();
        
        $csvFileName = 'profiles_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Add headers
        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Address', 'Status', 'Created At']);
        
        // Add data
        foreach ($profiles as $profile) {
            fputcsv($handle, [
                $profile->id,
                $profile->name,
                $profile->email,
                $profile->phone,
                $profile->address,
                $profile->status,
                $profile->created_at
            ]);
        }
        
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);
        
        return response($csvContent)
            ->withHeaders([
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
            ]);
    }

    public function trashed()
    {
        $profiles = Profile::onlyTrashed()->paginate(10);
        return view('profiles.trashed', compact('profiles'));
    }
}