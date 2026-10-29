<?php
namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMailHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\MailMessage;
class MailController extends Controller
{
// public function mailHistory(Request $request)
// {
//     $userId=Auth::user()->id;

//     // Fetch mail history for the user with pagination
//     $mails = UserMailHistory::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(10);

//     // Pass to the view
//     return view('web.user.mail-history', compact('mails'));
// }
public function mailHistory(Request $request)
{
    $userId = Auth::id();
    $type   = $request->input('type');
    $search = trim((string) $request->input('search'));

    $mails = UserMailHistory::where('user_id', $userId)
        ->when(in_array($type, ['campaign', 'offer', 'order'], true), function ($q) use ($type) {
            $q->where('mail_type', $type);
        })
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('site_url', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('blog_email', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

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
