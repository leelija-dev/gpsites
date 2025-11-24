<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\BlogMail;
use App\Models\Blog;
use App\Models\PlanOrder;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\MailAvailable;
use App\Models\UserMailHistory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
class BlogController extends Controller
{

    public function index(Request $request)
    {
        $response = Http::get(env('API_BASE_URL') . '/api/blogs');
        
        $mail_available = MailAvailable::where('user_id', Auth::user()->id)->get();//->latest()->first(); // or ->orderBy('id','desc')
        
        $isValidPlan = false;
        $total_mail_available=0;
        $total_mail=0;
        if($mail_available){
            foreach($mail_available as $mail_available){
                
            $plan_order_id= $mail_available->order_id;
    
            $plan_order=PlanOrder::where('id', $plan_order_id)->latest()->first();
            
            $plan_id=Plan::where('id', $plan_order->plan_id)->first() ;
            // $plan_expire=$plan_id->duration >=$plan_order->created_at;
            $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_id->duration) ;

            $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate) ? Carbon::now()->lessThanOrEqualTo($expiryDate): false;
            if(!$isValid){ // is expired 
                
                continue;    
            }else{
                $isValidPlan=true;
                $total_mail_available += $mail_available->available_mail;
                $total_mail +=$mail_available->total_mail;   
            }
                        
            }

            
        }
        else{
            return view('web.blog', compact('isValidPlan'));
        }
        // $plan_expire=$plan_id->duration ?? 0;
        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }

        $blogs = $response->json();
        $page = LengthAwarePaginator::resolveCurrentPage(); // current page number
        $perPage = 10; // Show 10 blogs per page
        $offset = ($page - 1) * $perPage;

        $items = array_slice($blogs, $offset, $perPage);

        $pagination = new LengthAwarePaginator(
            $items,
            count($blogs), // total count
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        return view('web.blog', compact('pagination', 'total_mail_available','isValidPlan','total_mail'));
    }
    public function viewMail($id)
    {
        $id = decrypt($id);


        return view('web.client_Mail', compact('id'));
    }
    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:20480|nullable',
        ]);
        $response = Http::get(env('API_BASE_URL') . '/api/blogs');

        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }
        $blogs = $response->json();
        $selectedIds = json_decode($request->selected_ids);
         $attachment = [];
            $uploadPath = public_path('attachment'); // Folder path

        // Create folder if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true); // 0755 permissions, true for recursive
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $attachment[] = 'attachment/' . $fileName; // relative path
                }
            }
        }
        foreach ($selectedIds as $id) {
            $blog = collect($blogs['data'])->firstWhere('blog_id', $id);

            $email = $blog['created_by'];

            // $email = decrypt($email);
            $subject = $request->input('subject');
            $messageBody = $request->input('message'); // From Summernote
            $user_id = $request->userId;

           
       
            // $mail = Mail::raw(strip_tags($messageBody), function ($message) use ($email, $subject) {
            //     $message->to($email)
            //         ->subject($subject);
            // });
            $mail=Mail::to($email)->send(new \App\Mail\MailWithAttachment(
            $subject,
            $messageBody,
            $attachment // this is an array of strings (paths)
        ));
            if ($mail) {
                UserMailHistory::create([
                    'user_id' => $user_id,
                    'site_url' => $blog['site_url'],
                    'subject' => $subject,
                    'message' => $messageBody,
                    'file' => !empty($attachment) ? implode(',', $attachment) : null,

                ]);
                $lastMail = MailAvailable::where('user_id', Auth::id())
                    ->latest() // or ->orderBy('id','desc')
                    ->first();

                if ($lastMail) {
                    $lastMail->decrement('available_mail', 1);
                }
            }
        }
        return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
    }
    public function singleMail(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
            'id' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:20480|nullable',
        ]);

        $id = $request->id;
        $response = Http::get(env('API_BASE_URL') . '/api/blogs');
        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }

        $blogs = $response->json();
        $blog = collect($blogs['data'])->firstWhere('blog_id', $id);

        $email = $blog['created_by'];
        $subject = $request->input('subject');
        $messageBody = $request->input('message');
        $messageForDB = strip_tags($messageBody);
        $user_id = $request->userId;
        

        // Store attachments in public/attachment folder
        $attachment = [];
        $uploadPath = public_path('attachment'); // Folder path

        // Create folder if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true); // 0755 permissions, true for recursive
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $attachment[] = 'attachment/' . $fileName; // relative path
                }
            }
        }


        // Send email
        Mail::to($email)->send(new \App\Mail\MailWithAttachment(
            $subject,
            $messageBody,
            $attachment // this is an array of strings (paths)
        ));

        // Save mail history
        UserMailHistory::create([
            'user_id' => $user_id,
            'site_url' => $blog['site_url'],
            'subject' => $subject,
            'message' => $messageForDB,
            'file' => !empty($attachment) ? implode(',', $attachment) : null,
        ]);

        // MailAvailable::where('user_id', Auth::id())->decrement('available_mail', 1);
        $lastMail = MailAvailable::where('user_id', Auth::id())
            ->latest() // or ->orderBy('id','desc')
            ->first();

        if ($lastMail) {
            $lastMail->decrement('available_mail', 1);
}

        return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
    }
}
