<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('refers', 'delivered_orders')->latest()->paginate(pagination_limit());
        return view('backend.user.index', compact('users'));
    }

    public function details($id)
    {
        $user = User::with('delivered_orders')->find($id);
        $refers = User::withCount('delivered_orders')->where('refer_by', $user->id)->paginate(10);
        $total_refer_earning  = Transaction::where('user_id', $user->id)->where('tran_type', 'refer_bonus')->sum('amount');
        $total_deposits  = Deposit::where('user_id', $user->id)->where('status', 'Completed')->sum('amount');
        $total_withdraw  = Withdraw::where('user_id', $user->id)->sum('amount');
        $total_convert = Transaction::where('user_id', $user->id)->where('tran_type', 'convert_balance')->sum('amount');
        return view('backend.user.details', compact('user', 'refers', 'total_refer_earning', 'total_deposits', 'total_withdraw', 'total_convert'));
    }

    public function status(Request $request, $id)
    {
        $request->validate([
           'status' => 'required|in:0,1'
        ]);
        $user = User::find($id);
        $user->status = $request->status;
        $user->update();
        return redirect()->back()->with('success', 'Status successfully update');
    }

    public function transactions(Request $request)
    {
        $request->flash();
        $transactions = Transaction::with('user');
        if ($request->email){
            $user = User::where('email', $request->email)->first(['id']);
            $transactions = $transactions->where('user_id', $user->id);
        }
        $transactions = $transactions->orderBy('id', 'desc')->paginate(pagination_limit());
        return view('backend.user.transactions', compact('transactions'));
    }

}
