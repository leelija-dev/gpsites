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
        $app_name = config('app.name');
        $date = now()->format('d-m-Y, h:i A');
        $subject =$data['subject'];
        $body=$this->contactmail($data['name'],$data['email'],$subject,$data['message'],$app_name,$date);
        
                    if($email!=null){
                    try{
                        Mail::html($body, function ($message) use ($email,$subject) {
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
public function contactmail($name,$email,$subject,$message,$app_name,$date){
  $body='<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#e5e7eb;">
    <tr>
        <td align="center" style="padding:20px 10px;">

            <!-- Main Container -->
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:620px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,0.12);">

                <!-- Header -->
                <tr>
                    <td align="center" style="background:linear-gradient(135deg,#7c3aed,#a855f7); padding:40px 20px;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:#ffffff; margin-bottom:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.678 4.74a2.25 2.25 0 0 1-2.004 0L3.57 8.66A2.25 2.25 0 0 1 2.5 6.993V6.75"/>
                        </svg>
                        <h1 style="color:#ffffff; margin:0; font-size:26px; font-weight:bold; line-height:1.3;">New Contact Message</h1>
                        <p style="color:#e9d5ff; margin:12px 0 0; font-size:16px;">Someone just submitted the contact form</p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:32px 24px; color:#1f2937; line-height:1.7;">

                        <p style="margin:0 0 16px; font-size:17px;">Hello Admin,</p>

                        <p style="margin:0 0 24px; font-size:15px; color:#374151;">
                            You have received a new message from the contact form. Here are the details:
                        </p>

                        <!-- Info Card -->
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9fafb; border-radius:12px; border:1px solid #e5e7eb;">
                            <tr>
                                <td style="padding:20px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Sender Name</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 16px; font-size:15px; color:#111827;">'.$name.'</td>
                                        </tr>

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Email Address</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 16px; font-size:15px; color:#111827;">
                                                <a href="mailto:'.$email.'" style="color:#4f46e5; text-decoration:none;">'.$email.'</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Subject</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 0 16px; font-size:15px; color:#111827;">'.$subject.'</td>
                                        </tr>

                                        <tr>
                                            <td style="padding:8px 0; font-size:13px; color:#6b7280;"><strong>Message</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0; font-size:15px; color:#111827; line-height:1.8; word-break:break-word;">
                                                '.$message.'
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>

                       

                        <p style="margin:32px 0 0; font-size:13px; color:#6b7280; text-align:center;">
                            This message was sent via the contact form on '.$app_name.'<br>
                            Received on '.$date.'
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="background:#1e293b; padding:24px; color:#94a3b8; font-size:13px;">
                        © 2025 <strong style="color:#ffffff;">'.$app_name.'</strong> — Contact Form Notification<br>
                        All contact inquiries are monitored and responded to within 24 hours.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>';
  return $body;
}
}
