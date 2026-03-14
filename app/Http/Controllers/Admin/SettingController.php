<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $settings = $request->except(['_token', '_method']);
        
        $fileInputs = ['site_logo']; 
        
        foreach ($settings as $key => $value) {
            if (in_array($key, $fileInputs)) {
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $file = $request->file($key);
                    
                    // Delete old file if exists
                    $oldPath = Setting::get($key);
                    if ($oldPath) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    
                    // Windows tmp workaround
                    $filename = $file->hashName();
                    $contents = file_get_contents($file->getPathname());
                    $path = 'settings/' . $filename;
                    
                    Storage::disk('public')->put($path, $contents);
                    Setting::set($key, $path);
                }
            } else {
                Setting::set($key, $value);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
