<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use function Nette\Utils\data;

class SslcommerzController extends Controller
{

    private $config_value;
    private $direct_api_url;
    private $host;

    public function __construct()
    {
        $config = get_settings('ssl_commerz');
        if (!is_null($config) && $config['mode'] == 'live') {

            $this->config_value = $config;
            $this->direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
            $this->host = false;
        } elseif (!is_null($config) && $config['mode'] == 'test') {
            $this->config_value = $config;
            $this->direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
            $this->host = false;
        }

    }


    public function deposit_sslcommerz_pay(Request $request)
    {
        if($request['ZGF0YQ=='] == null){
            notify()->error('something went to wrong');
            return redirect()->route('user.deposit_list');
        };
        $data = Crypt::decryptString($request['ZGF0YQ==']);
        $data = json_decode($data, true);

        if (@$data['amount'] == '' || $data['user_id'] == '' || $data['payment_method'] == ''){
            notify()->error('Data missing');
            return redirect()->route('user.deposit_list');
        }

        $amount = $data['amount'];
        $user = Auth::user();

        $post_data = array();
        $post_data['store_id'] = $this->config_value['store_id'];
        $post_data['store_passwd'] = $this->config_value['store_password'];
        $post_data['total_amount'] = round($amount, 2);
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = uniqid();

        $post_data['success_url'] = route('deposit.sslcommerz.success');
        $post_data['fail_url'] = route('deposit.sslcommerz.fail');
        $post_data['cancel_url'] = route('deposit.sslcommerz.cancel');

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = 'N/A';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "";
        $post_data['cus_phone'] = $user->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "N/A";
        $post_data['ship_add1'] = "N/A";
        $post_data['ship_add2'] = "N/A";
        $post_data['ship_city'] = "N/A";
        $post_data['ship_state'] = "N/A";
        $post_data['ship_postcode'] = "N/A";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "N/A";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "N/A";
        $post_data['product_category'] = "N/A";
        $post_data['product_profile'] = "service";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $user->id;
        $post_data['value_b'] = $amount;
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $this->host); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            return back();
        }

        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            exit;
        } else {
            notify()->error($sslcz['failedreason']);
            return redirect()->route('user.deposit_list');
        }
    }

    protected function SSLCOMMERZ_hash_verify($store_passwd, $post_data)
    {
        if (isset($post_data) && isset($post_data['verify_sign']) && isset($post_data['verify_key'])) {
            # NEW ARRAY DECLARED TO TAKE VALUE OF ALL POST
            $pre_define_key = explode(',', $post_data['verify_key']);

            $new_data = array();
            if (!empty($pre_define_key)) {
                foreach ($pre_define_key as $value) {
                    if (isset($post_data[$value])) {
                        $new_data[$value] = ($post_data[$value]);
                    }
                }
            }
            # ADD MD5 OF STORE PASSWORD
            $new_data['store_passwd'] = md5($store_passwd);

            # SORT THE KEY AS BEFORE
            ksort($new_data);

            $hash_string = "";
            foreach ($new_data as $key => $value) {
                $hash_string .= $key . '=' . ($value) . '&';
            }
            $hash_string = rtrim($hash_string, '&');

            if (md5($hash_string) == $post_data['verify_sign']) {

                return true;
            } else {
                $this->error = "Verification signature not matched";
                return false;
            }
        } else {
            $this->error = 'Required data mission. ex: verify_key, verify_sign';
            return false;
        }
    }

    public function deposit_sslcommerz_success(Request $request){
        $user_id = $request->value_a;
        $amount = $request->value_b;
        Auth::loginUsingId($user_id, true);
        if ($request->status == 'VALID' && $this->SSLCOMMERZ_hash_verify($this->config_value['store_password'], $request)){

            $transaction_id = $request->input('tran_id');
            $check_data = Deposit::where('transaction_id', $transaction_id)->count();
            if ($check_data > 0){
                notify()->error('Deposit already completed');
                return redirect()->route('user.deposit_list');
            }

            $deposit = new Deposit();
            $deposit->user_id = $user_id;
            $deposit->amount = $amount;
            $deposit->transaction_id = $transaction_id;
            $deposit->payment_method = 'SSLCOMMERZ';
            $deposit->status = 'Completed';
            $deposit->save();

            $user = User::find($user_id);
            $user->balance = $user->balance + $amount;
            $user->update();

            addDepositLog($user_id,$amount);

            notify()->success('Deposit added successfully.');
            return redirect()->route('user.deposit_list');

        }else{
            notify()->error('Error','Deposit failed');
            return redirect()->route('user.deposit_list');
        }
    }

    public function deposit_sslcommerz_fail(Request $request)
    {
        notify()->error('Error', 'Deposit failed');
        return redirect()->route('user.deposit_list');
    }

    public function deposit_sslcommerz_cancel(Request $request)
    {
        notify()->error('Error','Deposit cancelled');
        return redirect()->route('user.deposit_list');
    }



    //sslcommerz payment
    public function payment_sslcommerz_pay(Request $request)
    {
        if($request['b3JkZXJfZGF0YQ'] == null){
            notify()->error('something went to wrong');
            return redirect('/');
        }
        $order_id = Crypt::decrypt($request['b3JkZXJfZGF0YQ']);

        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();

        if ($order == null){
            notify()->error('something went to wrong');
            return redirect('/');
        }

        if ($order->payment_method != 'SSLCOMMERZ'){
            notify()->error('Online payment not found');
            return redirect('/');
        }

        if ($order->payment_status == 1){
            notify()->error('Payment already completed');
            return redirect('/');
        }

        if ($order->payment_status == 'Delivered' || $order->status == 'Cancelled' || $order->payment_status == 'Failed'){
            notify()->error('Order already '.$order->status);
            return redirect('/');
        }

        $amount = $order['grand_total'];
        $user = Auth::user();


        $post_data = array();
        $post_data['store_id'] = $this->config_value['store_id'];
        $post_data['store_passwd'] = $this->config_value['store_password'];
        $post_data['total_amount'] = round($amount, 2);
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = uniqid();

        $post_data['success_url'] = route('payment.sslcommerz.success');
        $post_data['fail_url'] = route('payment.sslcommerz.fail');
        $post_data['cancel_url'] = route('payment.sslcommerz.cancel');

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = 'N/A';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "";
        $post_data['cus_phone'] = $user->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "N/A";
        $post_data['ship_add1'] = "N/A";
        $post_data['ship_add2'] = "N/A";
        $post_data['ship_city'] = "N/A";
        $post_data['ship_state'] = "N/A";
        $post_data['ship_postcode'] = "N/A";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "N/A";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "N/A";
        $post_data['product_category'] = "N/A";
        $post_data['product_profile'] = "service";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $user->id;
        $post_data['value_b'] = $amount;
        $post_data['value_c'] = $order_id;
        $post_data['value_d'] = "ref004";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $this->host); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close($handle);
            return back();
        }

        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            exit;
        } else {
            notify()->error($sslcz['failedreason']);
            return redirect()->route('user.deposit_list');
        }
    }


    public function payment_sslcommerz_success(Request $request){
        $user_id = $request->value_a;
        $order_id = $request->value_c;

        $order = Order::where('user_id', $user_id)->where('id', $order_id)->first();

        if ($order->payment_method != 'SSLCOMMERZ'){
            notify()->error('Online payment not found');
            return redirect('/');
        }

        if ($order == null){
            notify()->error('something went to wrong');
            return redirect('/');
        }

        if ($order->payment_status == 1){
            notify()->error('Payment already completed');
            return redirect('/');
        }

        if ($order->payment_status == 'Delivered' || $order->status == 'Cancelled' || $order->payment_status == 'Failed'){
            notify()->error('Order already '.$order->status);
            return redirect('/');
        }

        Auth::loginUsingId($user_id, true);

        if ($request->status == 'VALID' && $this->SSLCOMMERZ_hash_verify($this->config_value['store_password'], $request)){

            $transaction_id = $request->input('tran_id');
            $check_data = Order::where('transaction_id', $transaction_id)->count();
            if ($check_data > 0){
                notify()->error('Transaction already completed');
                return redirect('/');
            }

            $order->transaction_id = $transaction_id;
            $order->payment_status = 1;
            $order->status = 'Confirmed';
            $order->update();

            return redirect()->route('order_complete', ['query' => base64_encode($order->id)]);

        }else{
            notify()->error('Error','Payment failed');
            return redirect('/');
        }
    }

    public function payment_sslcommerz_fail(Request $request)
    {
        $user_id = $request->value_a;
        $amount = $request->value_b;
        $order_id = $request->value_c;

        $order = Order::where('user_id', $user_id)->where('id', $order_id)->first();

        if ($order->payment_method != 'SSLCOMMERZ'){
            notify()->error('Online payment not found');
            return redirect('/');
        }

        if ($order == null){
            notify()->error('something went to wrong');
            return redirect('/');
        }

        if ($order->payment_status == 1){
            notify()->error('Payment already completed');
            return redirect('/');
        }

        if ($order->payment_status == 'Delivered' || $order->status == 'Cancelled' || $order->payment_status == 'Failed'){
            notify()->error('Order already '.$order->status);
            return redirect('/');
        }

        $order->status = 'Failed';
        $order->update();

        notify()->error('Payment has been failed');
        return redirect('/');

    }

    public function payment_sslcommerz_cancel(Request $request)
    {
        $user_id = $request->value_a;
        $amount = $request->value_b;
        $order_id = $request->value_c;

        $order = Order::where('user_id', $user_id)->where('id', $order_id)->first();

        if ($order->payment_method != 'SSLCOMMERZ'){
            notify()->error('Online payment not found');
            return redirect('/');
        }

        if ($order == null){
            notify()->error('something went to wrong');
            return redirect('/');
        }

        if ($order->payment_status == 1){
            notify()->error('Payment already completed');
            return redirect('/');
        }

        if ($order->payment_status == 'Delivered' || $order->status == 'Cancelled' || $order->payment_status == 'Failed'){
            notify()->error('Order already '.$order->status);
            return redirect('/');
        }

        $order->status = 'Cancelled';
        $order->update();

        notify()->error('Payment has been canceled');
        return redirect('/');
    }
}
