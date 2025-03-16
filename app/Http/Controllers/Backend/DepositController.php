<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('user:id,name,email')->latest()->paginate(pagination_limit());
        return view('backend.deposit.index', compact('deposits'));
    }

    public function details($id)
    {
        $deposit = Deposit::find($id);
        return view('backend.deposit.deposit_details', compact('deposit'));
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled',
        ]);

        $deposit = Deposit::find($id);

        if ($deposit->status == $request->status){
            return redirect()->back()->with('error', "You can not update the same status");
        }

        if ($deposit->status == 'Completed' || $deposit->status == 'Cancelled'){
            return redirect()->back()->with('error', "You are not eligible to update the status");
        }

        $deposit->status = $request->status;
        $deposit->update();

        if ($deposit->status == 'Completed'){
            $user = User::find($deposit->user_id);
            $user->balance = $user->balance + $deposit->amount;
            $user->update();
            addDepositLog($deposit->user_id, $deposit->amount);
        }

        return redirect()->back()->with('success', 'Deposit status updated');
    }

}
