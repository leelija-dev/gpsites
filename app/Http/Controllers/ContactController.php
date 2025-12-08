<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class ContactController extends Controller
{
 public function store(Request $request){
  $data=$request->validate([
    'name'=>'string|required',
    'email'=>'email|required',
    'phone'=>'string|nullable',
    'subject'=>'string|nullable',
    'message'=>'string|nullable',
    
  ]);


  $store=Contact::create($data);

  if($store){
        $email = config('mail.admin_email');
        $subject =$data['subject'];
        $body = "
                Hello Admin,\n\n"
                        ."User contact"
                        . "Name: {$data['name']}\n"
                        . "email: {$data['email']}\n"
                        . "Message: {$data['message']}\n";
                    if($email!=null){
                    try{
                        Mail::raw($body, function ($message) use ($email,$subject) {
                        $message->to($email)
                            ->subject($subject);
                    });
                  }catch(\Exception $e){
                   Log::error('Contact mail could not be sent: ' . $e->getMessage(), [
                    'exception' => $e,
                    'user email' => $email
                ]);
                  }

                  }
              
  return redirect()->route('contact')->with('success','Message sent successfully');
  } 
  return back()->with('error', 'Something went wrong, please try again.');
}
}
