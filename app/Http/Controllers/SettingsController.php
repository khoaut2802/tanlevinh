<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        try {
            $settings = Settings::get();

            return view('backend.settings', compact('settings'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $settings = Settings::get();
            $data = $request->all();

            foreach($settings as $setting) {
                if($request->has($setting->key)) {
                    Settings::where('key', $setting->key)->update([
                        'value' => $data[$setting->key]
                    ]);
                } else {
                    if($setting->type == 'select') {
                        Settings::where('key', $setting->key)->update([
                            'value' => 'off'
                        ]);
                    }
                }
            }

            return redirect(getSetting('admin_prefix').'/settings')->withSuccess('Thay đổi cài đặt thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }        
    }
}
