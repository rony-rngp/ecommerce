<?php

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

function get_settings($key){
    $config = null;
    $data = collect(app('app_settings'))->where('key', $key)->first();
    if (isset($data) && $data != null){
        $config = json_decode($data['value'], true);
        if (is_null($config)) {
            $config = $data['value'];
        }
    }
    return $config;
}

function pagination_limit(){
    return 25;
}

function base_currency(){
    return get_settings('currency_symbol').' ';
}

function base_currency_name(){
    return get_settings('currency_name').' ';
}

function upload_image($dir, $image = null){
    if ($image != null) {
        $ext = $image->getClientOriginalExtension();
        $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $ext;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dir)) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($dir);
        }
        \Illuminate\Support\Facades\Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
    } else {
        $imageName = '';
    }
    return $dir.$imageName;
}

function update_image( $dir, $old_image, $image = null){
    if ($old_image != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists( $old_image)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($old_image);
    }
    $imageName = upload_image($dir, $image);
    return $imageName;
}

function delete_image($full_path){
    if ($full_path != '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($full_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($full_path);
    }
}

function check_image($image = null){
   if( $image != '' && Storage::disk('public')->exists($image)){
       return true;
   }else{
       return false;
   }
}


function addReferEarning($order, $refer_by){

    $refer_income_percent = get_settings('refer_income');

    $bonus = ($refer_income_percent/100)*$order->grand_total;
    $bonus = round($bonus);

    if (get_settings('allow_refer_income') == 1){
        $transaction = new Transaction();
        $transaction->user_id = $refer_by;
        $transaction->tran_type = 'refer_bonus';
        $transaction->description = 'Referral bonus earned by ('.Auth::user()->name.') placing an order.';
        $transaction->amount_type = 'credit';
        $transaction->amount = $bonus;
        $transaction->reference = $order->id;
        $transaction->main_user = Auth::user()->id;
        $transaction->save();

        $user = \App\Models\User::find($refer_by);
        $user->refer_balance = $user->refer_balance + $bonus;
        $user->update();
    }
}


function addDepositLog($user_id, $amount){
    $user = \App\Models\User::find($user_id);
    $transaction = new Transaction();
    $transaction->user_id = $user_id;
    $transaction->tran_type = 'deposit';
    $transaction->description = 'Deposit of ('.base_currency().$amount.') successfully made by ('.$user->name.').';
    $transaction->amount_type = 'credit';
    $transaction->amount = $amount;
    $transaction->reference = null;
    $transaction->save();
}


function placeOrderLog($order){
    $user = \App\Models\User::find($order->user_id);
    $transaction = new Transaction();
    $transaction->user_id = $order->user_id;
    $transaction->tran_type = 'place_order';
    $transaction->description = '('.$user->name.') placed an order using their account balance. Order ID: ('.$order->id.').';
    $transaction->amount_type = 'debit';
    $transaction->amount = $order->grand_total;
    $transaction->reference = $order->id;
    $transaction->save();
}

function getAvg($rating){
    return ($rating/5)*100;
}
