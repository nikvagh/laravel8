<?php

namespace App\Http\Controllers;

use App\Models\IcamReferalEmailQueue;
use App\Models\IcamReferalEmailQueueNew;
use App\Models\Trafficesource;
use Illuminate\Http\Request;

class IcamController extends Controller
{
    public function convert_ref_email_to_new(){
        $data = IcamReferalEmailQueue::limit(1000)->get()->pluck('to_email')->toArray();

        $addDataArray = [];
        $deleteDataArray = [];
        foreach($data as $key=>$val){
            $addDataArray[$key] = ['email'=>$val];
            $deleteDataArray[] = $val;
        }

        // echo "<pre>";
        // print_r($addDataArray);
        // exit;
        IcamReferalEmailQueueNew::insert($addDataArray);
        IcamReferalEmailQueue::whereIn('to_email',$deleteDataArray)->delete();

        echo "<pre>";
        print_r($data);
        exit;
        // foreach($data as $val){
        //     IcamReferalEmailQueueNew::create(['email'=>$val]);
        //     IcamReferalEmailQueue::where('to_email',$val)->delete();
        // }
    }

    public function remove_duplicate_trafficesource($start){
        $data = Trafficesource::where('id','>',$start)->limit(5000)->get();
        // echo "<pre>";
        // print_r($data);
        // exit;

        foreach($data as $key=>$val){
            Trafficesource::where('host',$val->host)->where('id','!=',$val->id)->delete();
        }

        // echo "<pre>";
        // print_r($data);
        // exit;
    }

    public function remove_duplicate_info($start){
        $data = Trafficesource::where('id','>=',$start)->limit(5)->get();
        // echo "<pre>";
        // print_r($data);
        // exit;

        foreach($data as $key=>$val){
            Trafficesource::where('from',$val->from)->where('id','!=',$val->id)->delete();
        }

        // echo "<pre>";
        // print_r($data);
        // exit;
    }

    public function remove_duplicate_model_log_in($start){
        $data = Trafficesource::where('id','>=',$start)->limit(1000)->get();
        foreach($data as $key=>$val){
            Trafficesource::where('username',$val->username)->where('id','!=',$val->id)->delete();
        }
    }
}
