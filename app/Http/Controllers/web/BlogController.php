<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\BlogMail;
use App\Models\Blog;
use App\Models\PlanOrder;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\MailAvailable;
use App\Models\User;
use App\Models\UserMailHistory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class BlogController extends Controller
{
    protected $APIBASEURL;
    public function __construct()
    {
        $this->APIBASEURL = config('app.api_url');
    }
    public function index(Request $request)
    {   
        $APPURL  = $this->APIBASEURL .'/api/blogs';

        // $response = Http::get(env('API_BASE_URL') . '/api/blogs');
        $response = Http::get($APPURL , [
            'page' => $request->get('page', 1) // pass current page to API
        ]);


        $mail_available = MailAvailable::where('user_id', Auth::user()->id)->get(); //->latest()->first(); // or ->orderBy('id','desc')

        $isValidPlan = false;
        $total_mail_available = 0;
        $total_mail = 0;
        if ($mail_available && $mail_available->count() > 0) {
            foreach ($mail_available as $mail_available) {

                $plan_order_id = $mail_available->order_id;

                $plan_order = PlanOrder::where('id', $plan_order_id)->latest()->first();

                $plan_id = Plan::where('id', $plan_order->plan_id)->first();
                // $plan_expire=$plan_id->duration >=$plan_order->created_at;
                $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_id->duration);

                $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate) ? Carbon::now()->lessThanOrEqualTo($expiryDate) : false;
                if (!$isValid) { // is expired 

                    continue;
                } else {
                    $isValidPlan = true;
                    $total_mail_available += $mail_available->available_mail;
                    $total_mail += $mail_available->total_mail;
                }
            }
        } else {
            return view('web.blog', compact('isValidPlan'));
        }
        // $plan_expire=$plan_id->duration ?? 0;
        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }

        $blogs = $response->json();
        //$page = LengthAwarePaginator::resolveCurrentPage(); // current page number
        // $perPage = 10; // Show 10 blogs per page
        //$offset = ($page - 1) * $perPage;

        //$items = array_slice($blogs, $offset, $perPage);

        // $pagination = new LengthAwarePaginator(
        //     $items,
        //     count($blogs), // total count
        //     $perPage,
        //     $page,
        //     ['path' => url()->current()]
        // );
        $pagination = new LengthAwarePaginator(
            $blogs['data'],            // blog list
            $blogs['total'],           // total items
            $blogs['per_page'],        // per page
            $blogs['current_page'],    // current page
            ['path' => url()->current()]
        );

        return view('web.blog', compact('pagination', 'total_mail_available', 'isValidPlan', 'total_mail'));
    }
    public function viewMail($id)
    {
        $id = decrypt($id);
        $userId = Auth::user()->id;
        $trial_used = User::where('id', $userId)->first();
        $mail_available = MailAvailable::where('user_id', Auth::user()->id)->get();

        $isValidPlan = false;
        $total_mail_available = 0;
        $total_mail = 0;
        if ($mail_available && $mail_available->count() > 0) {
            foreach ($mail_available as $mail_available) {

                $plan_order_id = $mail_available->order_id;

                $plan_order = PlanOrder::where('id', $plan_order_id)->latest()->first();

                $plan_id = Plan::where('id', $plan_order->plan_id)->first();
                // $plan_expire=$plan_id->duration >=$plan_order->created_at;
                $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_id->duration);

                $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate) ? Carbon::now()->lessThanOrEqualTo($expiryDate) : false;
                if (!$isValid) { // is expired 

                    continue;
                } else {
                    $isValidPlan = true;
                    $total_mail_available += $mail_available->available_mail;
                    $total_mail += $mail_available->total_mail;
                }
            }
        } else if ($trial_used && (int)$trial_used->is_trial === 1) {
            // Trial path: allow if trial is active, not expired, and has credits > 0
            $trialValidDate = $trial_used->valid_trial_date ? Carbon::parse($trial_used->valid_trial_date) : null;
            $isTrialDateValid = $trialValidDate ? Carbon::now()->lessThanOrEqualTo($trialValidDate) : false;
            $trialCredits = (int) ($trial_used->mail_available ?? 0);

            if ($isTrialDateValid && $trialCredits > 0) {
                $isValidPlan = true;
                $total_mail_available = $trialCredits;
                $total_mail = $trialCredits;
            } else {
                $isValidPlan = false;
                $total_mail_available = 0;
                $total_mail = 0;
            }
        } else {
            return view('web.client_Mail', compact('isValidPlan'));
        }



        return view('web.client_Mail', compact('id', 'isValidPlan', 'total_mail_available'));
    }
    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:20480|nullable',
        ]);
        $APIURL  = $this->APIBASEURL .'/api/blogs';
        $response = Http::get($APIURL);

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
            $mail = Mail::to($email)->send(new \App\Mail\MailWithAttachment(
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
                // $lastMail = MailAvailable::where('user_id', Auth::id())
                //     ->latest() // or ->orderBy('id','desc')
                //     ->first();

                // if ($lastMail) {
                //     $lastMail->decrement('available_mail', 1);
                // }
                $this->decrementMailCount();
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

        $id = (int)$request->id;
        // print_r($id);


        // $response = Http::get(env('API_BASE_URL') . "/api/blogs/$id");
        $response = Http::get(env('API_BASE_URL') . "/api/blogs/$id");

        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }

        $blog = $response->json();
        // print_r($blog); die;

        // $blog = collect($blogs['data'])->where('blog_id', (int) $id);

        $email = $blog['updated_by'];
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

        // Determine eligibility: prefer paid plan, else trial
        $authUser = Auth::user();
        $hasPaidPlanCredit = false;
        $mailPlans = MailAvailable::where('user_id', $authUser->id)->orderBy('id','asc')->get();
        foreach ($mailPlans as $m) {
            $order = PlanOrder::where('id', $m->order_id)->first();
            if (!$order) continue;
            $plan = Plan::where('id', $order->plan_id)->first();
            if (!$plan) continue;
            $expiryDate = Carbon::parse($order->created_at)->addDays($plan->duration);
            if (Carbon::now()->lte($expiryDate) && $m->available_mail > 0) { $hasPaidPlanCredit = true; break; }
        }

        $usingTrial = false; $trialUser = null;
        if (!$hasPaidPlanCredit) {
            $trialUser = User::find($user_id);
            $trialValid = $trialUser && (int)$trialUser->is_trial === 1 && $trialUser->valid_trial_date
                && Carbon::now()->lte(Carbon::parse($trialUser->valid_trial_date))
                && (int)$trialUser->mail_available > 0;
            if (!$trialValid) {
                return back()->with('error', 'No valid plan or trial credits available.');
            }
            $usingTrial = true;
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

        // Decrement correct credit source
        if ($hasPaidPlanCredit) {
            $this->decrementMailCount();
        } elseif ($usingTrial && $trialUser) {
            $trialUser->decrement('mail_available', 1);
        }


        return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
    }
    public function decrementMailCount()
    {
        $mailPlans = MailAvailable::where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        foreach ($mailPlans as $mailPlan) {

            $order = PlanOrder::where('id', $mailPlan->order_id)->first();
            if (!$order) continue;

            $plan = Plan::where('id', $order->plan_id)->first();
            if (!$plan) continue;

            // Calculate expiry from PlanOrder created_at + plan duration
            $expiryDate = Carbon::parse($order->created_at)->addDays($plan->duration);

            if (Carbon::now()->greaterThan($expiryDate)) {
                continue; // skip expired plan
            }

            // Active plan check + available mail
            if ($mailPlan->available_mail > 0) {
                $mailPlan->decrement('available_mail', 1);
                return true;
            }
        }

        return false; // No valid active plans found
    }
    public function findNiches(Request $request)
    {
        // Selected Niches
        $niches = $request->niches;


        if (is_string($niches)) {
            $decoded = json_decode($niches, true);
            $niches = json_last_error() === JSON_ERROR_NONE ? $decoded : explode(',', $niches);
        }
        $niches = array_map('trim', (array)$niches);

        // Store temporary in session
        session(['selected_niches' => $niches]);

        // Login required
        // if (!Auth::check()) {
        //     return redirect()->route('login')
        //         ->with('error', 'Please login to see filtered blogs.');
        // }

        // Check active plan
        $mailData = MailAvailable::where('user_id', Auth::id())->get();
        $isValidPlan = false;
        $total_mail_available = 0;
        $total_mail = 0;

        foreach ($mailData as $mail) {
            $order = PlanOrder::find($mail->order_id);
            if (!$order) continue;

            $plan = Plan::find($order->plan_id);
            if (!$plan) continue;

            if (now()->lte($order->created_at->addDays($plan->duration))) {
                $isValidPlan = true;
                $total_mail_available += $mail->available_mail;
                $total_mail += $mail->total_mail;
            }
        }

        // if (!$isValidPlan) {
        //     return redirect()->route('pricing')->with('error', 'Please purchase a valid plan first!');
        // }

        // Build API Request
        $response = Http::get(env('API_BASE_URL') . '/api/blogs/search', [
            'niche' => implode(',', $niches),
            'da_max' => $request->get('da_max'),
            'da_min' => $request->get('da_min'),
            'dr_max' => $request->get('dr_max'),
            'dr_min' => $request->get('dr_min'),
            'traffic_min' => $request->get('traffic_min'),
            'traffic_max' => $request->get('traffic_max'),
            'page' => $request->get('page', 1),
            // 'per_page' => 20,
        ]);
        // print_r($response);die;

        if ($response->failed()) {
            return back()->with('error', 'API Failed: ' . $response->status());
        }

        $apiBlogs = $response->json();
        // Setup pagination from API response
        $pagination = new LengthAwarePaginator(
            $apiBlogs['data'],
            $apiBlogs['total'] ?? count($apiBlogs['data']),
            $apiBlogs['per_page'],
            $apiBlogs['current_page'],
            ['path' => url()->current(), 'query' => $request->query()]
        );
        // print_r($pagination);die;
        return view('web.niche_blog', compact(
            'pagination',
            'total_mail_available',
            'total_mail',
            'isValidPlan',
            'niches'
        ));
    }
}
