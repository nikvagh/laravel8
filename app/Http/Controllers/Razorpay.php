<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;

class Razorpay extends Controller
{
    public function razor_pay_form(){
        return view('razor_pay_form');
    }

    public function razor_pay_submit(){

        $amount = request()->amount;

        // Orders
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_KEY_SECRET'));
        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount, 'currency' => 'INR')); // Creates order
        $orderId = $order['id']; // Get the created Order ID

        Session::put('orderId', $orderId);
        Session::put('amount', $amount);

        // print_r(session()->all());
        // exit;


        $new_array = array();
        $new_array['orderId'] = $orderId;
        echo json_encode($new_array);
        exit;

        return view('razor_pay');
    }

    public function razor_pay_submit_next(){
        // Orders
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_KEY_SECRET'));
        $order  = $api->order->create(array('receipt' => '123', 'amount' => 100, 'currency' => 'INR')); // Creates order
        $orderId = $order['id']; // Get the created Order ID

        $new_array = array();
        $new_array['orderId'] = $orderId;
        // echo json_encode($new_array);
        // exit;

        return view('razor_pay_next')->with($new_array);
    }

    public function razor_pay_return(){

        // print_r(session()->all());
        $orderId = session('orderId');
        $amount = session('amount');
        // echo $orderId;

        // print_r(request()->all());

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_KEY_SECRET'));
        $razorpay_payment_id = request()->razorpay_payment_id;
        $payment  = $api->payment->fetch($razorpay_payment_id); 

        // echo $payment->amount;exit;
        if($payment->amount == $amount){
            echo "111";
            // order here
        }else{
            echo "222";
            // something went wrong
        }
        
        echo "<pre>";
        print_r($payment);

        exit;
    }

}
