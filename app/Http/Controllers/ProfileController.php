<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
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
