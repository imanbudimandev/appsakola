<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token');
        
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
