<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\OfflinePaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{
    public function deposit_list()
    {
        $deposits = Deposit::where('user_id', Auth::user()->id)->latest()->get();
        $offline_payment_methods = OfflinePaymentMethod::where('status', 1)->get();
        $total_deposit_amount = Deposit::where('user_id', Auth::user()->id)->where('status', 'Completed')->sum('amount');
        return view('frontend.user.deposit.deposit_list', compact('deposits', 'offline_payment_methods', 'total_deposit_amount'));
    }

    public function deposit_store(Request $request)
    {
        if ($request->payment_method == 'SSLCOMMERZ'){
            $request->validate([
                'amount' => 'required|numeric',
                'payment_method' => 'required',
            ]);

            if ($request->amount < 50){
                notify()->error('Minimum deposit amount '.base_currency().'50');
                return redirect()->back();
            }

            if(get_settings('online_payment_status') != 1){
                notify()->error('SSL COMMERZ is disabled. please try another deposit method');
                return redirect()->back();
            }

            $data = [
                'amount' => $request->amount,
                'user_id' => Auth::user()->id,
                'payment_method' => $request->payment_method
            ];

            return redirect()->route('deposit.sslcommerz.pay', [
                base64_encode('data') => Crypt::encryptString(json_encode($data))
            ]);

        }else{

            if(get_settings('offline_payment_status') != 1){
                notify()->error('Offline method is disabled. please try another deposit method');
                return redirect()->back();
            }

            $offline_payment_method = OfflinePaymentMethod::where('id', $request->payment_method)->first();
            if($offline_payment_method == null){
                notify()->error('Payment method not found');
                return redirect()->back();
            }

            $validate_array = [];
            $validate_array ['amount'] = 'required|numeric';

            foreach ($offline_payment_method['method_information'] ?? [] as $method_information){
                $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                $name = str_replace(' ', '_', $name_data);
                $name = strtolower($name);
                if ($method_information['input_filed_required'] == '1'){
                    $validate_array[$name] = 'required';
                }
            }
            $request->validate($validate_array);

            if ($request->amount < 50){
                notify()->error('Minimum deposit amount '.base_currency().'50');
                return redirect()->back();
            }

            $deposit = new Deposit();
            $deposit->user_id = Auth::user()->id;
            $deposit->amount = $request->amount;
            $deposit->payment_type = 'offline';
            $deposit->payment_method = $offline_payment_method['method_name'];

            $offline_payment_info = [];

            foreach ($offline_payment_method['method_information'] ?? [] as $method_information){
                $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                $name = str_replace(' ', '_', $name_data);
                $name = strtolower($name);

                $offline_payment_info[] = [
                    'key' => $method_information['input_filed_name'],
                    'value' => $request->$name,
                ];
            }

            $deposit->offline_payment_info = $offline_payment_info;
            $deposit->status = 'Pending';
            $deposit->save();

            notify()->success('Deposit added successfully. Please wait for admin approval');
            return redirect()->back();
        }
    }

    public function deposit_details($id)
    {
        $id = Crypt::decrypt($id);
        $deposit = Deposit::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        return view('frontend.user.deposit.deposit_details', compact('deposit'));
    }

}
