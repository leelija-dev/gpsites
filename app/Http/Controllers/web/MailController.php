<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMailHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\MailMessage;
class MailController extends Controller
{
public function mailHistory(Request $request)
{
    $userId=Auth::user()->id;

    // Fetch mail history for the user with pagination
    $mails = UserMailHistory::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(10);

    // Pass to the view
    return view('web.user.mail-history', compact('mails'));
}
public function viewMail($id){
    $id=decrypt($id);
    $mail=UserMailHistory::find($id);
    $allMessage = MailMessage::where('user_mail_history_id', $id)->get();
    
    if(empty($allMessage)){
        $messages = $mail;
    }else{
        $messages = $allMessage;
    }
    return view('web.user.view-mail',compact('mail','messages'));
}
}
