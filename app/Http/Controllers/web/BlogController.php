<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\BlogMail;
use App\Models\Blog;
use App\Models\UserMailHistory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    
    public function index(Request $request)
    {
         
    //     $response = Http::get(env('APP_BASE_URL').'/api/blogs'); //API URL
    // //    print_r($response);die;
    //     //Fetch data from API
    //     //$response = Http::get($apiUrl);
    //     $blogs = $response->json();
    //    print_r($blogs);die;
    //     return view('web.blog',compact('blogs'));
    $response = Http::get(env('APP_BASE_URL') . '/api/blogs');

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
    
    return view('web.blog', compact('blogs','pagination'));
    }
    public function viewMail($email)
    { 
        $email = decrypt($email);
        
        
        return view('web.client_Mail',compact('email'));
    }
    public function sendMail(Request $request )
{   
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    $response = Http::get(env('APP_BASE_URL') . '/api/blogs');

    if ($response->failed()) {
        return 'API Request Failed: ' . $response->status();
    }
    $blogs = $response->json();
    $selectedIds = json_decode($request->selected_ids);
    foreach ($selectedIds as $id) {
        $blog = collect($blogs['data'])->firstWhere('blog_id', $id);
        $email = $blog['created_by'];
        
    // $email = decrypt($email);
    $subject = $request->input('subject');
    $messageBody = $request->input('message'); // From Summernote
    $user_id=$request->userId;

    $mail=Mail::raw(strip_tags($messageBody), function ($message) use ($email, $subject) {
        $message->to($email)
                ->subject($subject);
    });
    if($mail){
        UserMailHistory::create([
            'user_id' => $user_id,
            'site_url'=>$blog['site_url'],
            'subject' => $subject,
            'message' => $messageBody,
            
        ]);

    }
    }
    return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
}


}