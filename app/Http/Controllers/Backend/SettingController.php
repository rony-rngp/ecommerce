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
                'online_payment_status' => 'required',
                'offline_payment_status' => 'required',
                'allow_cod' => 'required|in:0,1',
                'in_dhaka' => 'required|numeric',
                'outside_dhaka' => 'required|numeric',
                'allow_refer_income' => 'required|numeric',
                'refer_income' => 'required|numeric',
                'min_convert_amount' => 'required|numeric',
                'min_withdraw_amount' => 'required|numeric',
                'logo' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
                'favicon' => 'mimes:jpeg,jpg,png,gif,PNG|max:2048',
                'facebook' => 'required|url',
                'twitter' => 'required|url',
                'instagram' => 'required|url',
                'youtube' => 'required|url',
                'pinterest' => 'required|url',
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
            Setting::updateOrInsert(['key' => 'online_payment_status'], [
                'value' => $request['online_payment_status']
            ]);
            Setting::updateOrInsert(['key' => 'offline_payment_status'], [
                'value' => $request['offline_payment_status']
            ]);
            Setting::updateOrInsert(['key' => 'allow_cod'], [
                'value' => $request['allow_cod']
            ]);
            Setting::updateOrInsert(['key' => 'in_dhaka'], [
                'value' => $request['in_dhaka']
            ]);
            Setting::updateOrInsert(['key' => 'outside_dhaka'], [
                'value' => $request['outside_dhaka']
            ]);
            Setting::updateOrInsert(['key' => 'allow_refer_income'], [
                'value' => $request['allow_refer_income']
            ]);
            Setting::updateOrInsert(['key' => 'refer_income'], [
                'value' => $request['refer_income']
            ]);
            Setting::updateOrInsert(['key' => 'min_convert_amount'], [
                'value' => $request['min_convert_amount']
            ]);
            Setting::updateOrInsert(['key' => 'min_withdraw_amount'], [
                'value' => $request['min_withdraw_amount']
            ]);
            Setting::updateOrInsert(['key' => 'meta_keywords'], [
                'value' => $request['meta_keywords']
            ]);
            Setting::updateOrInsert(['key' => 'meta_description'], [
                'value' => $request['meta_description']
            ]);

            Setting::updateOrInsert(['key' => 'facebook'], [
                'value' => $request['facebook']
            ]);
            Setting::updateOrInsert(['key' => 'twitter'], [
                'value' => $request['twitter']
            ]);
            Setting::updateOrInsert(['key' => 'instagram'], [
                'value' => $request['instagram']
            ]);
            Setting::updateOrInsert(['key' => 'youtube'], [
                'value' => $request['youtube']
            ]);
            Setting::updateOrInsert(['key' => 'pinterest'], [
                'value' => $request['pinterest']
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
