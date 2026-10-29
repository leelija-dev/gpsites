<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\BlogOrderMail;
use App\Models\MailMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMailHistory;
class BlogOrderController extends Controller
{
    // Orders list
    public function index(Request $request)
    {
        $orders = BlogOrderMail::where('user_id', Auth::id())
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->search, function ($q, $s) {
                $q->where(function ($w) use ($s) {
                    $w->where('site_url', 'like', "%{$s}%")
                      ->orWhere('website_name', 'like', "%{$s}%")
                      ->orWhere('price_label', 'like', "%{$s}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('web.orders.index', compact('orders'));
    }

    // Order detail
    public function show($id)
    {
        $id=base64_decode($id);
        $order = BlogOrderMail::where('user_id', Auth::id())->findOrFail($id);

        return view('web.orders.show', compact('order'));
    }
   public function campaign(Request $request)
{
    $search = trim((string) $request->input('search'));
    $status = $request->input('status');   // '1' = Sent, '0' = Failed, '' = All

    $mails = UserMailHistory::where('user_id', Auth::id())
        ->where('mail_type', 'campaign')
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('site_url', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('blog_email', 'like', "%{$search}%");
            });
        })
        ->when(in_array($status, ['0', '1'], true), function ($q) use ($status) {
            $q->where('status', (int) $status);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();   // keeps search and status on page 2, 3...

    return view('web.campaign.index', compact('mails'));
}
    public function offer(Request $request)
{
    $search = trim((string) $request->input('search'));
    $status = $request->input('status');   // '1' = Sent, '0' = Failed, '' = All

    $mails = UserMailHistory::where('user_id', Auth::id())
        ->where('mail_type', 'offer')
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('site_url', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('blog_email', 'like', "%{$search}%");
            });
        })
        ->when(in_array($status, ['0', '1'], true), function ($q) use ($status) {
            $q->where('status', (int) $status);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('web.offer.index', compact('mails'));
}
public function viewCampaign($id){
    $id=decrypt($id);
    $mail=UserMailHistory::find($id);
    $allMessage = MailMessage::where('user_mail_history_id', $id)->get();
    
    if(empty($allMessage)){
        $messages = $mail;
    }else{
        $messages = $allMessage;
    }
    return view('web.campaign.conversion',compact('mail','messages'));
}
public function viewOffer($id){
    $id=decrypt($id);
    $mail=UserMailHistory::find($id);
    $allMessage = MailMessage::where('user_mail_history_id', $id)->get();
    
    if(empty($allMessage)){
        $messages = $mail;
    }else{
        $messages = $allMessage;
    }
    return view('web.offer.conversion',compact('mail','messages'));
}
public function viewOrder($id){
    $id=decrypt($id);
    $mail=UserMailHistory::find($id);
    $allMessage = MailMessage::where('user_mail_history_id', $id)->get();
    
    if(empty($allMessage)){
        $messages = $mail;
    }else{
        $messages = $allMessage;
    }
    return view('web.orders.conversion',compact('mail','messages'));
}
}