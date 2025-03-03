<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function website_settings(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'website_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'copyright_text' => 'required',
                'currency_name' => 'required',
                'currency_symbol' => 'required',
                'email_verification' => 'required',
                'logo' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
                'favicon' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
            ]);

            Setting::updateOrInsert(['key' => 'website_name'], [
                'value' => $request['website_name']
            ]);
            Setting::updateOrInsert(['key' => 'email'], [
                'value' => $request['email']
            ]);
            Setting::updateOrInsert(['key' => 'phone'], [
                'value' => $request['phone']
            ]);
            Setting::updateOrInsert(['key' => 'address'], [
                'value' => $request['address']
            ]);
            Setting::updateOrInsert(['key' => 'copyright_text'], [
                'value' => $request['copyright_text']
            ]);
            Setting::updateOrInsert(['key' => 'currency_name'], [
                'value' => $request['currency_name']
            ]);
            Setting::updateOrInsert(['key' => 'currency_symbol'], [
                'value' => $request['currency_symbol']
            ]);
            Setting::updateOrInsert(['key' => 'email_verification'], [
                'value' => $request['email_verification']
            ]);

            $logo = $request->file('logo');
            if($logo){
                Setting::updateOrInsert(['key' => 'logo'], [
                    'value' => update_image('settings/', get_settings('logo'), $request->file('logo'))
                ]);
            }

            $favicon = $request->file('favicon');
            if($favicon){
                Setting::updateOrInsert(['key' => 'favicon'], [
                    'value' => update_image('settings/', get_settings('favicon'), $request->file('favicon'))
                ]);
            }

            return redirect()->back()->with('success', 'Settings updated successfully');

        }
        return view('backend.setting.website_setting');
    }
}
