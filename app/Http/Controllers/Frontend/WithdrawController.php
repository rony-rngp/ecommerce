<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\OfflinePaymentMethod;
use App\Models\Transaction;
use App\Models\Withdraw;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class WithdrawController extends Controller
{
    public function withdraw_list()
    {
        $withdraws = Withdraw::where('user_id', Auth::user()->id)->latest()->get();
        $withdraw_methods = WithdrawMethod::where('status', 1)->get();
        $total_withdraw_amount = Withdraw::where('user_id', Auth::user()->id)->where('status', 'Completed')->sum('amount');
        $pending_withdraw_amount = Withdraw::where('user_id', Auth::user()->id)->where('status', 'Pending')->sum('amount');
        return view('frontend.user.withdraw.withdraw_list', compact('withdraws', 'withdraw_methods', 'total_withdraw_amount', 'pending_withdraw_amount'));
    }

    public function withdraw_store(Request $request)
    {

        $withdraw_method = WithdrawMethod::where('id', $request->payment_method)->first();
        if($withdraw_method == null){
            notify()->error('Withdraw method not found');
            return redirect()->back();
        }
        $validate_array = [];
        $validate_array ['amount'] = 'required|numeric';

        foreach ($withdraw_method['method_information'] ?? [] as $method_information){
            $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
            $name = str_replace(' ', '_', $name_data);
            $name = strtolower($name);
            if ($method_information['input_filed_required'] == '1'){
                $validate_array[$name] = 'required';
            }
        }
        $request->validate($validate_array);

        if ($request->amount < get_settings('min_withdraw_amount')){
            notify()->error('Minimum withdraw amount '.get_settings('min_withdraw_amount').' '.base_currency_name());
            return redirect()->back();
        }

        if(Auth::user()->refer_balance < $request->amount){
            notify()->error('You do not have enough balance');
            return redirect()->back();
        }

        try {
            $withdraw = new Withdraw();
            $withdraw->user_id = Auth::user()->id;
            $withdraw->withdraw_method = $withdraw_method['method_name'];

            $withdraw_method_info = [];
            foreach ($withdraw_method['method_information'] ?? [] as $method_information){
                $name_data = preg_replace('/\s+/', ' ', $method_information['input_filed_name']);
                $name = str_replace(' ', '_', $name_data);
                $name = strtolower($name);

                $withdraw_method_info[] = [
                    'key' => $method_information['input_filed_name'],
                    'value' => $request->$name,
                ];
            }
            $withdraw->withdraw_method_information = $withdraw_method_info;
            $withdraw->amount = $request->amount;
            $withdraw->status = 'Pending';
            $withdraw->save();

            $user = Auth::user();
            $user->refer_balance = $user->refer_balance - $request->amount;
            $user->update();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->tran_type = 'withdraw';
            $transaction->description = 'Withdrawal request of ('.base_currency().$request->amount.') successfully submitted by ('.$user->name.').';
            $transaction->amount_type = 'debit';
            $transaction->amount = $request->amount;
            $transaction->reference = null;
            $transaction->save();

            notify()->success('Withdraw request added successfully');
            return redirect()->route('user.withdraw_list');


        }catch (\Exception $exception){
            notify()->error($exception->getMessage());
            return redirect()->back();
        }
    }

    public function withdraw_details($id)
    {
        $id = Crypt::decrypt($id);
        $withdraw = Withdraw::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        return view('frontend.user.withdraw.withdraw_details', compact('withdraw'));
    }

}
