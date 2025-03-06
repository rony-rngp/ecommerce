<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OfflinePaymentMethod;
use Illuminate\Http\Request;

class OfflinePaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offline_payment_methods =  OfflinePaymentMethod::paginate(pagination_limit());
        return view('backend.offline_payment_method.index', compact('offline_payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.offline_payment_method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required',
            'field_name' => 'required',
            'field_name.*' => 'required',
            'field_data' => 'required',
            'field_data.*' => 'required',
            'input_filed_name' => 'required',
            'input_filed_name.*' => 'required',
            'input_filed_required' => 'required',
            'input_filed_required.*' => 'required',
        ]);

        $method_fields = [];
        foreach ($request->field_name as $key=>$field_name) {
            $method_fields[] = [
                'field_name' => $request->field_name[$key],
                'field_data' => $request->field_data[$key],
            ];
        }

        $method_information = [];
        foreach ($request->input_filed_name as $key=>$field_name) {
            $method_information[] = [
                'input_filed_name' => $field_name,
                'input_filed_required' => isset($request['input_filed_required']) && $request['input_filed_required'][$key] == 1 ? 1 : 0,
            ];
        }

        $offline_payment_method = new OfflinePaymentMethod();
        $offline_payment_method->method_name = $request->method_name;
        $offline_payment_method->method_fields = $method_fields;
        $offline_payment_method->method_information = $method_information;
        $offline_payment_method->payment_note = $request->payment_note;
        $offline_payment_method->status = $request->status;
        $offline_payment_method->save();


        return redirect()->route('admin.offline-payment-method.index')->with('success', 'Offline payment method crated successfully');

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
        $offline_payment_method = OfflinePaymentMethod::find($id);
        return view('backend.offline_payment_method.edit', compact('offline_payment_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'method_name' => 'required',
            'field_name' => 'required',
            'field_name.*' => 'required',
            'field_data' => 'required',
            'field_data.*' => 'required',
            'input_filed_name' => 'required',
            'input_filed_name.*' => 'required',
            'input_filed_required' => 'required',
            'input_filed_required.*' => 'required',
        ]);

        $method_fields = [];
        foreach ($request->field_name as $key=>$field_name) {
            $method_fields[] = [
                'field_name' => $request->field_name[$key],
                'field_data' => $request->field_data[$key],
            ];
        }

        $method_information = [];
        foreach ($request->input_filed_name as $key=>$field_name) {
            $method_information[] = [
                'input_filed_name' => $field_name,
                'input_filed_required' => isset($request['input_filed_required']) && $request['input_filed_required'][$key] == 1 ? 1 : 0,
            ];
        }

        $offline_payment_method = OfflinePaymentMethod::find($id);
        $offline_payment_method->method_name = $request->method_name;
        $offline_payment_method->method_fields = $method_fields;
        $offline_payment_method->method_information = $method_information;
        $offline_payment_method->payment_note = $request->payment_note;
        $offline_payment_method->status = $request->status;
        $offline_payment_method->save();

        return redirect()->route('admin.offline-payment-method.index')->with('success', 'Offline payment method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offline_payment_method = OfflinePaymentMethod::find($id);
        $offline_payment_method->delete();
        return redirect()->route('admin.offline-payment-method.index')->with('success', 'Offline payment method deleted successfully');
    }
}
