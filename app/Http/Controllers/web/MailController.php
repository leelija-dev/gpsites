<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMailHistory;

class MailController extends Controller
{
public function mailHistory($id){
    $id=decrypt($id);
    $mails=UserMailHistory::where('user_id',$id)->paginate(10);;
    return view('web.mail-history',compact('mails'));
}
public function viewMail($id){
    $id=decrypt($id);
    $mail=UserMailHistory::find($id);
    return view('web.view-mail',compact('mail'));
}
}
