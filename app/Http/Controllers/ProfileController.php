<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::orderBy('id', 'asc')->paginate(5);

        return view('profiles.index', compact('profiles'));
    }

    /*  AJAX SEARCH + PAGINATION */
    public function search(Request $request)
    {
        $query = Profile::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        $profiles = $query->orderBy('id', 'asc')->paginate(5);

        return response()->json([
            'data' => $profiles->items(),
            'links' => $profiles->links()->render()
        ]);
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        Profile::create($request->all());

        return redirect('/profiles')->with('success', 'Profile added successfully');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());

        return redirect('/profiles')->with('success', 'Profile updated successfully');
    }

    public function destroy($id)
    {
        Profile::destroy($id);
        return redirect('/profiles')->with('success', 'Profile deleted successfully');
    }
}
