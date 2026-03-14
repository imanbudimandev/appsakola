<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        
        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            if ($file->isValid()) {
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }
                
                try {
                    // Circumvent SplFileInfo::getRealPath() returning false on Windows/Laragon
                    $filename = $file->hashName();
                    $contents = file_get_contents($file->getPathname());
                    $path = 'profiles/' . $filename;
                    
                    Storage::disk('public')->put($path, $contents);
                    
                    $user->profile_photo = $path;
                } catch (\Throwable $e) {
                    return redirect()->back()->withErrors(['profile_photo' => 'Server failed to save the photo. Error: ' . $e->getMessage()]);
                }
            } else {
                return redirect()->back()->withErrors(['profile_photo' => 'The profile photo failed to upload. It might be too large (max 2MB) or corrupted.']);
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
