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

    public function frontend()
    {
        return view('admin.settings.frontend');
    }

    public function update(Request $request)
    {
        $settings = $request->except(['_token', '_method']);
        
        $fileInputs  = ['site_logo'];
        $arrayInputs = ['midtrans_payment_methods'];
        
        foreach ($settings as $key => $value) {
            if (in_array($key, $fileInputs)) {
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    $file = $request->file($key);
                    $oldPath = Setting::get($key);
                    if ($oldPath) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $filename = $file->hashName();
                    $contents = file_get_contents($file->getPathname());
                    $path = 'settings/' . $filename;
                    Storage::disk('public')->put($path, $contents);
                    Setting::set($key, $path);
                }
            } elseif (in_array($key, $arrayInputs)) {
                Setting::set($key, json_encode(is_array($value) ? $value : []));
            } else {
                Setting::set($key, $value);
            }
        }

        // If payment methods not submitted (all unchecked), save empty array
        if (!$request->has('midtrans_payment_methods')) {
            Setting::set('midtrans_payment_methods', json_encode([]));
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
