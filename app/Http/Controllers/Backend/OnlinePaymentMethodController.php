<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlinePaymentMethodController extends Controller
{
    public function online_payment_method()
    {
        $ssl_commerz = get_settings('ssl_commerz');
        if (!isset($ssl_commerz)){
            DB::table('settings')->updateOrInsert(['key' => 'ssl_commerz'], [
                'value' => '{"mode":"test","gateway_title":"SSL Commerz","store_id":"","store_password":"", "logo":""}'
            ]);
        }
        return view('backend.online_payment_method.index');
    }

    public function online_payment_method_update(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:test,live',
            'gateway_title' => 'required',
            'store_id' => 'required',
            'store_password' => 'required',
        ]);

        $data = [
            'mode' => $request->mode,
            'gateway_title' => $request->gateway_title,
            'store_id' => $request->store_id,
            'store_password' => $request->store_password,
            'logo' => '',
        ];

        DB::table('settings')->updateOrInsert(['key' => 'ssl_commerz'], [
            'value' => json_encode($data)
        ]);

        return redirect()->back()->with('success', 'Payment method updated');
    }

}
