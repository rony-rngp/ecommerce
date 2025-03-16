<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('frontend.user.dashboard');
    }

    public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('frontend.user.transactions.transaction_list', compact('transactions'));
    }

    public function my_refer(Request $request, $type='')
    {
        $total_refer_earning  = Transaction::where('user_id', Auth::user()->id)->where('tran_type', 'refer_bonus')->sum('amount');
        $withdraw_methods = WithdrawMethod::where('status', 1)->get();
        $users = null;
        $convert_logs = null;
        if ($type == ''){
            $users = User::withCount('delivered_orders')->where('refer_by', Auth::user()->id)->paginate(10);
        }else if ($type == 'convert_log'){
            $convert_logs = Transaction::where('user_id', Auth::user()->id)->where('tran_type', 'convert_balance')->orderBy('id', 'desc')->paginate(10);
        }else{
            abort(404);
        }
        return view('frontend.user.my_refer.refer_list', compact('users', 'total_refer_earning', 'convert_logs', 'type', 'withdraw_methods'));

    }

    public function convert_to_main_balance(Request $request)
    {
        if ($request->isMethod('post')){

            if ($request->amount == ''){
                notify()->error('The convert amount filed is required');
                return redirect()->back();
            }

            if ($request->amount < get_settings('min_convert_amount')){
                notify()->error('Minimum convert amount '.get_settings('min_convert_amount').' '.base_currency_name());
                return redirect()->back();
            }

            $user = Auth::user();

            if($user->refer_balance < $request->amount){
                notify()->error('Sorry, your account balance is low');
                return redirect()->back();
            }

            $transaction = new Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->tran_type = 'convert_balance';
            $transaction->description = '('.Auth::user()->name.') converted referral balance to main balance.';
            $transaction->amount_type = 'debit';
            $transaction->amount = $request->amount;
            $transaction->reference = null;
            $transaction->save();

            $transaction = new Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->tran_type = 'added_converted_balance';
            $transaction->description = '('.Auth::user()->name.') added converted referral balance to main balance.';
            $transaction->amount_type = 'credit';
            $transaction->amount = $request->amount;
            $transaction->reference = null;
            $transaction->save();


            $user->refer_balance = $user->refer_balance-$request->amount;
            $user->balance = $user->balance+$request->amount;
            $user->update();

            notify()->success('Refer balance converted successfully');
            return redirect()->back();

        }

        return view('frontend.user.my_refer.convert_to_main_balance');
    }

    public function account_details()
    {
        $user = Auth::user();
        return view('frontend.user.account_details', compact('user'));
    }

    public function update_account_details(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:8|unique:users,phone,'.Auth::user()->id,
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->update();

        notify()->success('Account details updated successfully');
        return redirect()->back();
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (Hash::check($request->current_password, Auth::user()->password)){
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->update();

            notify()->success('Password changed successfully');
            return redirect()->back();
        }else{
            throw ValidationException::withMessages(['current_password' => 'Your current password is wrong']);
        }
    }

}
