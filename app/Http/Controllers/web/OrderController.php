<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\PlanOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\MailAvailable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(){
        // $orders=PlanOrder::where('user_id', Auth::user()->id)->get();
        // $mail=MailAvailable::where('user_id', Auth::user()->id)->get();
        $orders = PlanOrder::where('user_id', Auth::id())
            ->with(['mailAvailable','plan'])
            ->get();
        
         return view('web.order-details',compact('orders'));

    }
    public function show($id){
        $orders=PlanOrder::where('id',$id)->first();
        return view('web.view-order-details',compact('orders'));

    }
}
