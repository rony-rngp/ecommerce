<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::with('user:id,name,email')->latest()->paginate(pagination_limit());
        return view('backend.withdraw.index', compact('withdraws'));
    }

    public function details($id)
    {
        $withdraw = Withdraw::find($id);
        return view('backend.withdraw.withdraw_details', compact('withdraw'));
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled',
        ]);

        $withdraw = Withdraw::find($id);
        $withdraw->status = $request->status;
        $withdraw->update();

        return redirect()->back()->with('success', 'Withdraw status updated');
    }
}
