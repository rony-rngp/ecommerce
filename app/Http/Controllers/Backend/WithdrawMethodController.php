<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdraw_methods =  WithdrawMethod::paginate(pagination_limit());
        return view('backend.withdraw_method.index', compact('withdraw_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.withdraw_method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required|unique:withdraw_methods,method_name',
            'input_filed_name' => 'required',
            'input_filed_name.*' => 'required',
            'input_filed_required' => 'required',
            'input_filed_required.*' => 'required',
        ]);


        $method_information = [];
        foreach ($request->input_filed_name as $key=>$field_name) {
            $method_information[] = [
                'input_filed_name' => $field_name,
                'input_filed_required' => isset($request['input_filed_required']) && $request['input_filed_required'][$key] == 1 ? 1 : 0,
            ];
        }

        $withdraw_method = new WithdrawMethod();
        $withdraw_method->method_name = $request->method_name;
        $withdraw_method->method_information = $method_information;
        $withdraw_method->status = $request->status;
        $withdraw_method->save();


        return redirect()->route('admin.withdraw-methods.index')->with('success', 'Withdraw method crated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $withdraw_method = WithdrawMethod::find($id);
        return view('backend.withdraw_method.edit', compact('withdraw_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'method_name' => 'required|unique:withdraw_methods,method_name,'.$id,
            'input_filed_name' => 'required',
            'input_filed_name.*' => 'required',
            'input_filed_required' => 'required',
            'input_filed_required.*' => 'required',
        ]);


        $method_information = [];
        foreach ($request->input_filed_name as $key=>$field_name) {
            $method_information[] = [
                'input_filed_name' => $field_name,
                'input_filed_required' => isset($request['input_filed_required']) && $request['input_filed_required'][$key] == 1 ? 1 : 0,
            ];
        }

        $withdraw_method = WithdrawMethod::find($id);
        $withdraw_method->method_name = $request->method_name;
        $withdraw_method->method_information = $method_information;
        $withdraw_method->status = $request->status;
        $withdraw_method->save();


        return redirect()->route('admin.withdraw-methods.index')->with('success', 'Withdraw method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $withdraw_method = WithdrawMethod::find($id);
        $withdraw_method->delete();
        return redirect()->route('admin.withdraw-methods.index')->with('success', 'Withdraw method deleted successfully');
    }
}
