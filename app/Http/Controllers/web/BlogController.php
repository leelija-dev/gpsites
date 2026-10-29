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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\MailMessage;
use Illuminate\Support\Str;
use App\Models\BlogOrderMail;
use Illuminate\Validation\Rule;
class BlogController extends Controller
{
    private const PRICE_LABELS = [
        'general_guest_post_price'       => 'General Guest Post',
        'general_link_insertion_price'   => 'General Link Insertion',
        'sensitive_guest_post_price'     => 'Sensitive Guest Post',
        'sensitive_link_insertion_price' => 'Sensitive Link Insertion',
    ];
    protected $APIBASEURL;
    public function __construct()
    {
        $this->APIBASEURL = config('app.api_url');
    }
    public function index(Request $request)
    {
        $APPURL  = $this->APIBASEURL . '/api/blogs';

        // $response = Http::get(env('API_BASE_URL') . '/api/blogs');
       $params = array_filter([
            'page'           => $request->get('page', 1),
            'website_niche'  => $request->input('niche'),
            'da_min'         => $request->input('da_min'),
            'da_max'         => $request->input('da_max'),
            'dr_min'         => $request->input('dr_min'),
            'dr_max'         => $request->input('dr_max'),
            'traffic_min'    => $request->input('traffic_min'),
        ], fn ($v) => $v !== null && $v !== '');
        $response = Http::get($APPURL, $params);
        

        $user = Auth::user();
        $mail_available = MailAvailable::where('user_id', $user->id)->get();

        $isValidPlan = false;
        $total_mail_available = 0;
        $total_mail = 0;

        // Check for valid paid plans only (trial users should NOT have access to blog content)
        if ($mail_available && $mail_available->count() > 0) {
            foreach ($mail_available as $mail_available_record) {
                $plan_order_id = $mail_available_record->order_id;
                $plan_order = PlanOrder::where('id', $plan_order_id)->latest()->first();

                if ($plan_order) {
                    $plan = Plan::where('id', $plan_order->plan_id)->first();

                    if ($plan) {
                        // Exclude trial plan from valid plans
                        if ($plan->id == config('paypal.trial_plan_id')) {
                            // $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_order->duration ?? 0);
                            $expiryDate=Carbon::parse($plan_order->expire_at);
                            $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate);
                            if($isValid)
                            {
                                $isValidPlan = true;
                                $total_mail_available+=$mail_available_record->available_mail;
                                $total_mail +=$mail_available_record->total_mail;
                            }
                            continue; // Skip trial plan - trial users cannot access blog content
                        }

                        // $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_order->duration ?? 0);
                        $expiryDate=Carbon::parse($plan_order->expire_at);
                        $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate);

                        if ($isValid) {
                            $isValidPlan = true;
                            $total_mail_available += $mail_available_record->available_mail;
                            $total_mail += $mail_available_record->total_mail;
                        }
                    }
                }
            }
        }

        // If no valid paid plan, deny access (trial users cannot access blog content)
        if (!$isValidPlan) {
            return view('web.user.blog', compact('isValidPlan'));
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
            // ['path' => url()->current()]
            ['path' => url()->current(), 'query' => $request->query()]
        );
        // dd($pagination);
        $nichesResponse = Http::get($this->APIBASEURL . '/api/niches');
        $niches_data = $nichesResponse->successful() ? ($nichesResponse->json() ?? []) : [];
        return view('web.user.blog', compact('pagination', 'total_mail_available', 'isValidPlan', 'total_mail','niches_data'));
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
                // $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan_order->duration ?? 0);
                $expiryDate = Carbon::parse($plan_order->expire_at ?? 0);
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
            return view('web.user.client_Mail', compact('isValidPlan'));
        }



        return view('web.user.client_Mail', compact('id', 'isValidPlan', 'total_mail_available'));
    }
    // public function sendMail(Request $request) //grpup mail
    // {
    //     $request->validate([
    //         'subject' => 'required|string|max:255',
    //         'message' => 'required|string',
    //         'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:20480|nullable',
    //     ]);
    //     $APIURL  = $this->APIBASEURL . '/api/blogs';
    //     $response = Http::get($APIURL);

    //     if ($response->failed()) {
    //         return 'API Request Failed: ' . $response->status();
    //     }
    //     $blogs = $response->json();
    //     $selectedIds = json_decode($request->selected_ids);
    //     $attachment = [];
    //     $uploadPath = public_path('attachment'); // Folder path

    //     // Create folder if it doesn't exist
    //     if (!is_dir($uploadPath)) {
    //         mkdir($uploadPath, 0755, true); // 0755 permissions, true for recursive
    //     }
    //     if ($request->hasFile('attachments')) {
    //         foreach ($request->file('attachments') as $file) {
    //             if ($file && $file->isValid()) {
    //                 $fileName = time() . '_' . $file->getClientOriginalName();
    //                 $file->move($uploadPath, $fileName);
    //                 $attachment[] = 'attachment/' . $fileName; // relative path
    //             }
    //         }
    //     }
    //     if(count($selectedIds) == 1){
    //         $blogId = $selectedIds;
    //         $blog = collect($blogs['data'])->firstWhere('blog_id', $blogId);
    //         $email=$blog['contact_email_id'] ?? '';
    //         if($email==null){
    //             return redirect()->route('blog.index')->with('error', 'No email address available at the moment.');
    //         }
    //     }
        
    //     foreach ($selectedIds as $id) {
    //         $blog = collect($blogs['data'])->firstWhere('blog_id', $id);

    //         $email = $blog['contact_email_id'];

    //         // $email = decrypt($email);
    //         $subject = $request->input('subject');
    //         $messageBody = $request->input('message'); // From Summernote
    //         $user_id = $request->userId;



    //         // $mail = Mail::raw(strip_tags($messageBody), function ($message) use ($email, $subject) {
    //         //     $message->to($email)
    //         //         ->subject($subject);
    //         // });
    //         if($email==null){
    //              UserMailHistory::create([
    //                 'user_id' => $user_id,
    //                 'site_url' => $blog['site_url'],
    //                 'subject' => $subject,
    //                 'message' => $messageBody,
    //                 'file' => !empty($attachment) ? implode(',', $attachment) : null,
    //                 'status'=>false,
    //                 'description'=>'Mail record not found.'

    //             ]);
    //             Log::error('Email is null. Mail cannot be sent.', [
    //             'email' => $email,
    //             'blog_id' => $id ?? null,
    //             'site_url' => $blog['site_url'] ?? null,
    //             ]); 

    //             continue;
    //         }
    //         try{
    //         Mail::to($email)->send(new \App\Mail\MailWithAttachment(
    //             $subject,
    //             $messageBody,
    //             $attachment // this is an array of strings (paths)
    //         ));
                
    //             UserMailHistory::create([
    //                 'user_id' => $user_id,
    //                 'site_url' => $blog['site_url'],
    //                 'subject' => $subject,
    //                 'message' => $messageBody,
    //                 'file' => !empty($attachment) ? implode(',', $attachment) : null,
    //                 'status'=>true

    //             ]);
    //             // $lastMail = MailAvailable::where('user_id', Auth::id())
    //             //     ->latest() // or ->orderBy('id','desc')
    //             //     ->first();

    //             // if ($lastMail) {
    //             //     $lastMail->decrement('available_mail', 1);
    //             // }
    //             $this->decrementMailCount();
            

         
    //     }catch (\Exception $e) {

    //         UserMailHistory::create([
    //                 'user_id' => $user_id,
    //                 'site_url' => $blog['site_url'],
    //                 'subject' => $subject,
    //                 'message' => $messageBody,
    //                 'file' => !empty($attachment) ? implode(',', $attachment) : null,
    //                 'status'=>false,
    //                 'description'=>'Mail not send'.$e->getMessage()

    //             ]);
    //         Log::error('Mail sending exception: '.$e->getMessage(), [
    //             'email' => $email,
    //             'exception' => $e
    //         ]);
    //     }
            
    //     }
    //     return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
    // }
    public function sendMail(Request $request) // group mail
{
    $user    = Auth::user();
    $user_id = $user->id;

    $selectedIds = json_decode($request->selected_ids, true);
    if (!is_array($selectedIds) || empty($selectedIds)) {
        return response()->json(['message' => 'No site selected.'], 422);
    }
    $selectedIds = array_values(array_unique($selectedIds));

    $blogs = collect();
$page = 1;
$lastPage = 1;

do {
    $res = Http::get($this->APIBASEURL . '/api/blogs', ['page' => $page]);

    if ($res->failed()) {
        return response()->json(['message' => 'API Request Failed: ' . $res->status()], 502);
    }

    $blogs = $blogs->merge($res->json('data') ?? []);
    $lastPage = (int) $res->json('last_page', 1);
    $page++;
} while ($page <= $lastPage);

Log::info('Blogs loaded', [
    'count'   => $blogs->count(),
    'has_649' => $blogs->contains(fn ($b) => (string) ($b['blog_id'] ?? '') === '649'),
]);
    $subject = 'User interested in your blog';
    $messageBody = '
<div style="background:#f3f4f6;padding:24px 12px;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">

    <!-- Header -->
    <tr>
      <td style="background:#7c3aed;background-image:linear-gradient(135deg,#2563eb,#7c3aed);padding:28px 32px;color:#ffffff;">
        <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;opacity:.85;">Collaboration Request</div>
        <div style="font-size:22px;font-weight:bold;margin-top:6px;">Guest Post / Collaboration Opportunity</div>
      </td>
    </tr>

    <!-- Body -->
    <tr>
      <td style="padding:28px 32px;color:#374151;font-size:15px;line-height:1.6;">
        <p style="margin:0 0 16px;">Hello,</p>
        <p style="margin:0 0 20px;">
          I am interested in a guest post / collaboration opportunity on your website,
          and I would love to know if you are open to working together.
        </p>

        <!-- Reply card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;margin:0 0 24px;">
          <tr>
            <td style="padding:16px 18px;color:#4c1d95;font-size:15px;">
              If you are interested, simply <strong>reply to this email</strong> and we can discuss the details.
            </td>
          </tr>
        </table>

        <p style="margin:0 0 24px;">Thank you for your time.</p>

        <!-- Signature -->
        <p style="margin:0;padding-top:16px;border-top:1px solid #e5e7eb;">
          Regards,<br>
          <strong style="color:#111827;">' . e($user->name) . '</strong><br>
        </p>
      </td>
    </tr>

  </table>
</div>';

    $sent = 0;
    $noEmail = 0;
    $failed = 0;
    $lastError = null;
    foreach ($selectedIds as $id) {
        // $blog = $blogs->firstWhere('blog_id', $id);
        // $blog = collect($blogs['data'])->firstWhere('blog_id', $id);
        $blog = $blogs->first(fn ($b) => (string) ($b['blog_id'] ?? '') === (string) $id);


        if (!$blog) {
            Log::error('Blog not found in API', ['blog_id' => $id]);
            $failed++;
            continue;
        }

        $email   = trim($blog['contact_email_id'] ?? '');
        $siteUrl = $blog['site_url'] ?? null;

        $history = [
            'user_id'  => $user_id,
            'site_url' => $siteUrl,
            'subject'  => $subject,
            'mail_type' =>'campaign',
            'message'  => $messageBody,
            'file'     => null,
        ];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            UserMailHistory::create($history + [
                'status'      => false,
                'description' => 'Mail record not found.',
            ]);
            Log::error('Email is null/invalid. Mail cannot be sent.', [
                'email'    => $email,
                'blog_id'  => $id,
                'site_url' => $siteUrl,
            ]);
            $noEmail++;
            continue;
        }

        // $cc = collect([$user->email, config('mail.admin_email')])
        //     ->filter()
        //     ->map(fn ($e) => strtolower($e))
        //     ->unique()
        //     ->reject(fn ($e) => $e === strtolower($email))
        //     ->values()
        //     ->all();
        // $replyTo = collect([
        //         ['email' => $user->email, 'name' => $user->name],
        //         ['email' => config('mail.admin_email'), 'name' => 'Admin'],
        //     ])->filter(fn ($r) => !empty($r['email']))
        //     ->unique('email')
        //     ->values()
        //     ->all();
        // try {
        //     Mail::to($email)->cc($cc)->send(new \App\Mail\MailWithAttachment(
        //         $subject,
        //         $messageBody,
        //         [],
        //         $replyTo
        //     ));

        //     UserMailHistory::create($history + ['status' => true]);
        //     $this->decrementMailCount();
        //     $sent++;
        // } catch (\Throwable $e) {
        // $lastError = $e->getMessage();
        // UserMailHistory::create($history + [
        //     'status'      => false,
        //     'description' => 'Mail not send ' . $e->getMessage(),
        // ]);
        // Log::error('Mail sending exception: ' . $e->getMessage(), ['email' => $email]);
        // $failed++;
        // continue;
        $token = Str::lower(Str::random(12));
[$local, $domain] = explode('@', config('mail.site_inbox'));
$replyAddress = "{$local}+{$token}@{$domain}";

// BCC so the blog owner can't reply around your site
$bcc = collect([$user->email, config('mail.admin_email')])
    ->filter()->map(fn ($e) => strtolower($e))->unique()
    ->reject(fn ($e) => $e === strtolower($email))
    ->values()->all();

try {
    $sentMessage = Mail::to($email)->bcc($bcc)->send(new \App\Mail\MailWithAttachment(
        $subject,
        $messageBody,
        [],
        // [],
        [['email' => $replyAddress, 'name' => config('app.name')]],
        $replyAddress // Send FROM token address
    ));

    $thread = UserMailHistory::create($history + [
        'status'      => true,
        'reply_token' => $token,
        'blog_email'  => $email,
        'blog_id'     => $id,
    ]);

    $thread->messages()->create([
        'direction'  => 'initial',
        'from_email' => $replyAddress, // Store the token address
        'from_name'  => config('app.name'),
        'to_emails'  => [$email],
        'bcc_emails' => $bcc,
        'subject'    => $subject,
        'body_html'  => $messageBody,
        'body_text'  => strip_tags($messageBody),
        'message_id' => $sentMessage ? trim((string) $sentMessage->getMessageId(), '<> ') : null,
        'status'     => 'sent',
        'sent_at'    => now(),
    ]);

    $this->decrementMailCount();
    $sent++;
} catch (\Throwable $e) {
    $lastError = $e->getMessage();
    UserMailHistory::create($history + [
        'status'      => false,
        'description' => 'Mail not send ' . Str::limit($e->getMessage(), 500),
    ]);
    Log::error('Mail sending exception: ' . $e->getMessage(), ['email' => $email]);
    $failed++;
    continue;
    }
    }

    // Build an honest response
  if ($sent === 0) {
    $msg = $noEmail > 0 && $failed === 0
        ? 'No email address available for the selected site(s).'
        : 'Mail could not be sent. Please try again.';

    if (config('app.debug') && $lastError) {
        $msg .= ' [' . $lastError . ']';
    }
    return response()->json(['message' => $msg], 422);
  }
    $msg = "{$sent} mail(s) sent successfully.";
    if ($noEmail) $msg .= " {$noEmail} skipped (no email address).";
    if ($failed)  $msg .= " {$failed} failed.";

    return response()->json(['message' => $msg]);
}
    private function availableMailCount($user): int
    {
        $total = 0;
        foreach (MailAvailable::where('user_id', $user->id)->get() as $m) {
            $order = PlanOrder::find($m->order_id);
            if (!$order) continue;
            if (Carbon::now()->gt(Carbon::parse($order->expire_at ?? 0))) continue; // expired plan
            $total += (int) $m->available_mail;
        }
        return $total;
    }

    public function sendOffer(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|integer',
            'offer'   => 'required|numeric|min:1|max:1000000',
        ]);

        $user = Auth::user();

        if ($this->availableMailCount($user) < 1) {
            return response()->json(['message' => 'No valid plan or mail credits available.'], 422);
        }

        $blogId = (int) $request->blog_id;
        $res = Http::get($this->APIBASEURL . "/api/blogs/$blogId");
        if ($res->failed()) {
            return response()->json(['message' => 'API Request Failed: ' . $res->status()], 502);
        }

        $blog    = $res->json();
        $email   = trim($blog['contact_email_id'] ?? '');
        $siteUrl = $blog['site_url'] ?? null;

        // Subject and body are fixed by the backend. Only the offer comes from the user.
        $host    = parse_url((string) $siteUrl, PHP_URL_HOST) ?: $siteUrl;
        $offer   = number_format((float) $request->offer, 2);
        $subject = 'Guest post offer for ' . $host;
        // $messageBody = '
        //     <p>Hello,</p>
        //     <p>I am interested in a guest post on your website <strong>' . e($siteUrl) . '</strong>.</p>
        //     <p>My offer for the post is <strong>$' . $offer . '</strong>.</p>
        //     <p>Please reply to this email if you are interested.</p>
        //     <p>Regards,<br>' . e($user->name) . '<br>' . e($user->email) . '</p>
        // ';
        $messageBody = '
<div style="background:#f3f4f6;padding:24px 12px;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">

    <!-- Header -->
    <tr>
      <td style="background:#7c3aed;background-image:linear-gradient(135deg,#2563eb,#7c3aed);padding:28px 32px;color:#ffffff;">
        <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;opacity:.85;">Guest Post Offer</div>
        <div style="font-size:22px;font-weight:bold;margin-top:6px;">Offer for ' . e($siteUrl) . '</div>
      </td>
    </tr>

    <!-- Body -->
    <tr>
      <td style="padding:28px 32px;color:#374151;font-size:15px;line-height:1.6;">
        <p style="margin:0 0 16px;">Hello,</p>
        <p style="margin:0 0 20px;">
          I am interested in a guest post on your website
          <a href="' . e($siteUrl) . '" style="color:#2563eb;font-weight:bold;text-decoration:none;">' . e($siteUrl) . '</a>.
        </p>

        <!-- Offer card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;margin:0 0 24px;">
          <tr>
            <td style="padding:16px 18px;color:#6b7280;font-size:13px;">My offer for the post is</td>
            <td style="padding:16px 18px;text-align:right;font-weight:bold;font-size:24px;color:#7c3aed;">$' . e($offer) . '</td>
          </tr>
        </table>

        <p style="margin:0 0 24px;">Please reply to this email if you are interested.</p>

        <!-- Signature -->
        <p style="margin:0;padding-top:16px;border-top:1px solid #e5e7eb;">
          Regards,<br>
          <strong style="color:#111827;">' . e($user->name) . '</strong><br>
          
        </p>
      </td>
    </tr>

  </table>
</div>';

        $history = [
            'user_id'  => $user->id,
            'site_url' => $siteUrl,
            'mail_type' => 'offer',
            'subject'  => $subject,
            'message'  => $messageBody,
            'file'     => null,
        ];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            UserMailHistory::create($history + [
                'status'      => false,
                'description' => 'Mail record not found.',
            ]);
            return response()->json(['message' => 'No email address available for this site.'], 422);
        }

        // Same token and BCC logic as group mail
        $token = Str::lower(Str::random(12));
        [$local, $domain] = explode('@', config('mail.site_inbox'));
        $replyAddress = "{$local}+{$token}@{$domain}";

        $bcc = collect([$user->email, config('mail.admin_email')])
            ->filter()->map(fn ($e) => strtolower($e))->unique()
            ->reject(fn ($e) => $e === strtolower($email))
            ->values()->all();

        try {
            $sentMessage = Mail::to($email)->bcc($bcc)->send(new \App\Mail\MailWithAttachment(
                $subject,
                $messageBody,
                [],
                [['email' => $replyAddress, 'name' => config('app.name')]], // Reply-To = token address
                $replyAddress
            ));

            $thread = UserMailHistory::create($history + [
                'status'      => true,
                'reply_token' => $token,
                'blog_email'  => $email,
                'blog_id'     => $blogId,
            ]);

            $thread->messages()->create([
                'direction'  => 'initial',
                'from_email' => $replyAddress,
                'from_name'  => config('app.name'),
                'to_emails'  => [$email],
                'bcc_emails' => $bcc,
                'subject'    => $subject,
                'body_html'  => $messageBody,
                'body_text'  => strip_tags($messageBody),
                'message_id' => $sentMessage ? trim((string) $sentMessage->getMessageId(), '<> ') : null,
                'status'     => 'sent',
                'sent_at'    => now(),
            ]);

            $this->decrementMailCount();
        } catch (\Throwable $e) {
            UserMailHistory::create($history + [
                'status'      => false,
                'description' => 'Mail not send ' . Str::limit($e->getMessage(), 500),
            ]);
            Log::error('Offer mail failed: ' . $e->getMessage(), ['email' => $email]);
            return response()->json(['message' => 'Mail could not be sent. Please try again.'], 422);
        }

        return response()->json([
            'message'   => 'Offer sent successfully.',
            'available' => $this->availableMailCount($user),
        ]);
    }
        // Allow only simple formatting. Strips scripts, styles and all attributes except safe link hrefs.
    private function cleanOrderHtml(string $html): string
    {
        $html = trim(strip_tags($html, '<p><br><b><strong><i><em><u><ul><ol><li><a><h1><h2><h3><h4><blockquote>'));
        if ($html === '') return '';

        // plain text (no tags left): keep line breaks
        if ($html === strip_tags($html)) {
            return nl2br(e($html));
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

              $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//*') as $el) {
            if (!($el instanceof \DOMElement)) {
                continue;
            }

            foreach (iterator_to_array($el->attributes) as $attr) {
                $safeHref = $el->tagName === 'a'
                    && $attr->name === 'href'
                    && preg_match('#^(https?://|mailto:)#i', trim($attr->value));

                if (!$safeHref) {
                    $el->removeAttribute($attr->name);
                }
            }

            if ($el->tagName === 'a') {
                $el->setAttribute('target', '_blank');
                $el->setAttribute('rel', 'nofollow noopener');
            }
        }
        $out = '';
        foreach ($dom->documentElement->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }
        return trim($out);
    }

    // Sends one tracked mail (same logic as group mail) and stores the thread. Throws on failure.
    private function sendTrackedMail($user, int $blogId, string $email, ?string $siteUrl, string $subject, string $body): UserMailHistory
    {
        $token = Str::lower(Str::random(12));
        [$local, $domain] = explode('@', config('mail.site_inbox'));
        $replyAddress = "{$local}+{$token}@{$domain}";

        // Same as group mail: user and admin get a BCC copy
        $bcc = collect([$user->email, config('mail.admin_email')])
            ->filter()->map(fn ($e) => strtolower($e))->unique()
            ->reject(fn ($e) => $e === strtolower($email))
            ->values()->all();

        $sentMessage = Mail::to($email)->bcc($bcc)->send(new \App\Mail\MailWithAttachment(
            $subject,
            $body,
            [],
            [['email' => $replyAddress, 'name' => config('app.name')]], // Reply-To = token address
            $replyAddress
        ));

        $thread = UserMailHistory::create([
            'user_id'     => $user->id,
            'site_url'    => $siteUrl,
            'subject'     => $subject,
            'message'     => $body,
            'mail_type'   => 'order',
            'file'        => null,
            'status'      => true,
            'reply_token' => $token,
            'blog_email'  => $email,
            'blog_id'     => $blogId,
        ]);

        $thread->messages()->create([
            'direction'  => 'initial',
            'from_email' => $replyAddress,
            'from_name'  => config('app.name'),
            'to_emails'  => [$email],
            'bcc_emails' => $bcc,
            'subject'    => $subject,
            'body_html'  => $body,
            'body_text'  => strip_tags($body),
            'message_id' => $sentMessage ? trim((string) $sentMessage->getMessageId(), '<> ') : null,
            'status'     => 'sent',
            'sent_at'    => now(),
        ]);

        return $thread;
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'blog_id'    => 'required|integer',
            'price_type' => ['required', Rule::in(array_keys(self::PRICE_LABELS))],
            'content'    => 'required|string|max:30000',
        ]);

        $user = Auth::user();

        if ($this->availableMailCount($user) < 1) {
            return response()->json(['message' => 'No valid plan or mail credits available.'], 422);
        }

        $blogId = (int) $request->blog_id;
        $res = Http::get($this->APIBASEURL . "/api/blogs/$blogId");
        if ($res->failed()) {
            return response()->json(['message' => 'API Request Failed: ' . $res->status()], 502);
        }

        $blog    = $res->json();
        $email   = trim($blog['contact_email_id'] ?? '');
        $siteUrl = $blog['site_url'] ?? null;

        // The price comes from the backend/API, never from the browser
        $type  = $request->price_type;
        $price = (float) ($blog[$type] ?? 0);
        if ($price <= 0) {
            return response()->json(['message' => 'This service is not available for this site.'], 422);
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'No email address available for this site.'], 422);
        }

        $content = $this->cleanOrderHtml((string) $request->content);
        if (trim(strip_tags($content)) === '') {
            return response()->json(['message' => 'Please add your link or article.'], 422);
        }

        $label     = self::PRICE_LABELS[$type];
        $priceText = '$' . rtrim(rtrim(number_format($price, 2), '0'), '.');
        $host      = parse_url((string) $siteUrl, PHP_URL_HOST) ?: $siteUrl;

        // 1) STORE the order first, so nothing is lost if the mail fails
        $order = BlogOrderMail::create([
            'user_id'      => $user->id,
            'blog_id'      => $blogId,
            'website_name' => $blog['website_name'] ?? null,
            'site_url'     => $siteUrl,
            'blog_email'   => $email,
            'price_type'   => $type,
            'price_label'  => $label,
            'price'        => $price,
            'content'      => $content,
            'status'       => 'pending',
        ]);

        $subject = "Order request: {$label} on {$host}";
        $allowedTags = '<p><br><b><strong><i><em><u><ul><ol><li><a>';
$safeContent = strip_tags($content, $allowedTags);

$body = '
<div style="background:#f3f4f6;padding:24px 12px;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">

    <!-- Header -->
    <tr>
      <td style="background:#7c3aed;background-image:linear-gradient(135deg,#2563eb,#7c3aed);padding:28px 32px;color:#ffffff;">
        <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;opacity:.85;">New Order Request</div>
        <div style="font-size:22px;font-weight:bold;margin-top:6px;">Order for ' . e($siteUrl) . '</div>
      </td>
    </tr>

    <!-- Body -->
    <tr>
      <td style="padding:28px 32px;color:#374151;font-size:15px;line-height:1.6;">
        <p style="margin:0 0 16px;">Hello,</p>
        <p style="margin:0 0 20px;">
          I would like to place an order on your website
          <a href="' . e($siteUrl) . '" style="color:#2563eb;font-weight:bold;text-decoration:none;">' . e($siteUrl) . '</a>.
        </p>

        <!-- Order summary -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;margin:0 0 24px;">
          <tr>
            <td style="padding:14px 18px;color:#6b7280;font-size:13px;">Service</td>
            <td style="padding:14px 18px;text-align:right;font-weight:bold;color:#111827;">' . e($label) . '</td>
          </tr>
          <tr>
            <td style="padding:14px 18px;border-top:1px solid #e9d5ff;color:#6b7280;font-size:13px;">Price</td>
            <td style="padding:14px 18px;border-top:1px solid #e9d5ff;text-align:right;font-weight:bold;font-size:18px;color:#7c3aed;">' . e($priceText) . '</td>
          </tr>
        </table>

        <!-- Buyer details -->
        <p style="margin:0 0 8px;font-weight:bold;color:#111827;">Details from the buyer</p>
        <div style="background:#f9fafb;border-left:4px solid #7c3aed;border-radius:6px;padding:14px 16px;margin:0 0 24px;word-break:break-word;">
          ' . $safeContent . '
        </div>

        <p style="margin:0 0 24px;">Please reply to this email to confirm the order.</p>

        <!-- Signature -->
        <p style="margin:0;padding-top:16px;border-top:1px solid #e5e7eb;">
          Regards,<br>
          <strong style="color:#111827;">' . e($user->name) . '</strong><br>
         
        </p>
      </td>
    </tr>

  </table>
</div>';

        // 2) SEND the mail (tracked, same as group mail)
        try {
            $thread = $this->sendTrackedMail($user, $blogId, $email, $siteUrl, $subject, $body);
            $order->update(['status' => 'mailed', 'user_mail_history_id' => $thread->id]);
            $this->decrementMailCount(); // remove this line if orders should not use a mail credit
        } catch (\Throwable $e) {
            $order->update(['status' => 'failed', 'error' => Str::limit($e->getMessage(), 1000)]);
            Log::error('Order mail failed: ' . $e->getMessage(), ['order_id' => $order->id]);
            return response()->json(['message' => 'Order saved but the mail could not be sent. Please try again.'], 422);
        }

        return response()->json([
            'message'   => 'Order placed successfully.',
            'order_id'  => $order->id,
            'available' => $this->availableMailCount($user),
        ]);
    }
    // public function singleMail(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required|string',
    //         'subject' => 'required|string',
    //         'id' => 'required|string',
    //         'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,txt|max:20480|nullable',
    //     ]);

    //     $id = (int)$request->id;
    //     // print_r($id);


    //     // $response = Http::get(env('API_BASE_URL') . "/api/blogs/$id");
    //     $response = Http::get(env('API_BASE_URL') . "/api/blogs/$id");

    //     if ($response->failed()) {
    //         return 'API Request Failed: ' . $response->status();
    //     }

    //     $blog = $response->json();
    //     // print_r($blog); die;

    //     // $blog = collect($blogs['data'])->where('blog_id', (int) $id);

    //     $email = $blog['updated_by'];
    //     $subject = $request->input('subject');
    //     $messageBody = $request->input('message');
    //     $messageForDB = strip_tags($messageBody);
    //     $user_id = $request->userId;


    //     // Store attachments in public/attachment folder
    //     $attachment = [];
    //     $uploadPath = public_path('attachment'); // Folder path

    //     // Create folder if it doesn't exist
    //     if (!is_dir($uploadPath)) {
    //         mkdir($uploadPath, 0755, true); // 0755 permissions, true for recursive
    //     }
    //     if ($request->hasFile('attachments')) {
    //         foreach ($request->file('attachments') as $file) {
    //             if ($file && $file->isValid()) {
    //                 $fileName = time() . '_' . $file->getClientOriginalName();
    //                 $file->move($uploadPath, $fileName);
    //                 $attachment[] = 'attachment/' . $fileName; // relative path
    //             }
    //         }
    //     }

    //     // Check for valid paid plans only (trial users should NOT have access to blog functionality)
    //     $authUser = Auth::user();
    //     $hasPaidPlanCredit = false;
    //     $mailPlans = MailAvailable::where('user_id', $authUser->id)->orderBy('id','asc')->get();
    //     foreach ($mailPlans as $m) {
    //         $order = PlanOrder::where('id', $m->order_id)->first();
    //         if (!$order) continue;
    //         $plan = Plan::where('id', $order->plan_id)->first();
    //         if (!$plan) continue;

        //         // Exclude trial plan from valid plans
        //         if ($plan->id == config('paypal.trial_plan_id')) {
    //             continue; // Skip trial plan - trial users cannot access blog functionality
    //         }

    //         $expiryDate = Carbon::parse($order->created_at)->addDays($plan->duration);
    //         if (Carbon::now()->lte($expiryDate) && $m->available_mail > 0) { $hasPaidPlanCredit = true; break; }
    //     }

    //     // If no valid paid plan, deny access (trial users cannot send emails)
    //     if (!$hasPaidPlanCredit) {
    //         return back()->with('error', 'No valid paid plan available. Trial users cannot access blog functionality.');
    //     }

    //     // Send email
    //     Mail::to($email)->send(new \App\Mail\MailWithAttachment(
    //         $subject,
    //         $messageBody,
    //         $attachment // this is an array of strings (paths)
    //     ));

    //     // Save mail history
    //     UserMailHistory::create([
    //         'user_id' => $user_id,
    //         'site_url' => $blog['site_url'],
    //         'subject' => $subject,
    //         'message' => $messageForDB,
    //         'file' => !empty($attachment) ? implode(',', $attachment) : null,
    //     ]);

    //     // Decrement mail credits from paid plan
    //     if ($hasPaidPlanCredit) {
    //         $this->decrementMailCount();
    //     }


    //     return redirect()->route('blog.index')->with('success', 'Email sent successfully.');
    // }

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

         $APIURL  = $this->APIBASEURL ."/api/blogs/$id";
       
        // $response = Http::get(env('API_BASE_URL') . "/api/blogs/$id");
        $response = Http::get($APIURL);

        if ($response->failed()) {
            return 'API Request Failed: ' . $response->status();
        }

        $blog = $response->json();
        // print_r($blog); die;

        // $blog = collect($blogs['data'])->where('blog_id', (int) $id);

        $email = $blog['contact_email_id'];
        $subject = $request->input('subject');
        $messageBody = $request->input('message');
        $messageForDB = $messageBody;
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
        $mailPlans = MailAvailable::where('user_id', $authUser->id)->orderBy('id', 'asc')->get();
        foreach ($mailPlans as $m) {
            $order = PlanOrder::where('id', $m->order_id)->first();
            if (!$order) continue;
            $plan = Plan::where('id', $order->plan_id)->first();
            if (!$plan) continue;
            // $expiryDate = Carbon::parse($order->created_at)->addDays($order->duration ?? 0);
            $expiryDate = Carbon::parse($order->expire_at ?? 0);
            if (Carbon::now()->lte($expiryDate) && $m->available_mail > 0) {
                $hasPaidPlanCredit = true;
                break;
            }
        }

        $usingTrial = false;
        $trialUser = null;
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
        if ($email == null) {
            UserMailHistory::create([
                    'user_id' => $user_id,
                    'site_url' => $blog['site_url'],
                    'subject' => $subject,
                    'message' => $messageBody,
                    'file' => !empty($attachment) ? implode(',', $attachment) : null,
                    'status'=>false,
                    'description'=>'Mail record not found.'

                ]);
            Log::error('Email is null. Mail cannot be sent.', [
                'email' => $email,
                'blog_id' => $id ?? null,
                'site_url'=> $blog['site_url']?? null,
            ]);  // log message

        return redirect()->route('blog.index')
        ->with('error', 'No email address available at the moment.'); //usermessage
        }
       try {
        Mail::to($email)->send(new \App\Mail\MailWithAttachment(
            $subject,
            $messageBody,
            $attachment, // this is an array of strings (paths)
            []
        ));
        // Check if mail failed
        }catch (\Exception $e) {


            UserMailHistory::create([
                    'user_id' => $user_id,
                    'site_url' => $blog['site_url'],
                    'subject' => $subject,
                    'message' => $messageBody,
                    'file' => !empty($attachment) ? implode(',', $attachment) : null,
                    'status'=>false,
                    'description'=>$e->getMessage(),

                ]);
            Log::error('Mail sending exception: '.$e->getMessage(), [
                'email' => $email,
                'exception' => $e
            ]);

            return redirect()->route('blog.index')
                ->with('error', 'Mail could not be sent due to a server issue.');
        }
        

        // Save mail history
        UserMailHistory::create([
            'user_id' => $user_id,
            'site_url' => $blog['site_url'],
            'subject' => $subject,
            'message' => $messageBody,
            'file' => !empty($attachment) ? implode(',', $attachment) : null,
            'status'=>true
            
        ]);
        $this->decrementMailCount();
        // Decrement correct credit source



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
            // $expiryDate = Carbon::parse($order->created_at)->addDays($order->duration ?? 0);
            $expiryDate = Carbon::parse($order->expire_at ?? 0);

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

        // Check if user is logged in for plan validation
        $user = Auth::user();
        $isValidPlan = false;
        $total_mail_available = 0;
        $total_mail = 0;

        // Only check plan for logged-in users
        if ($user) {
            $mailData = MailAvailable::where('user_id', $user->id)->get();

        // Check for valid paid plans only (trial users should NOT have access to blog functionality)
        foreach ($mailData as $mail) {
            $order = PlanOrder::find($mail->order_id);
            if (!$order) continue;

            $plan = Plan::find($order->plan_id);
            if (!$plan) continue;

            // Exclude trial plan from valid plans
            if ($plan->id == config('paypal.trial_plan_id')) {
                continue; // Skip trial plan - trial users cannot access blog content
            }
            $duration = round(\Carbon\Carbon::parse($order->created_at)
                    ->floatDiffInDays(\Carbon\Carbon::parse($order->expire_at)));

            if (now()->lte($order->created_at->addDays($duration ?? 0))) {
                $isValidPlan = true;
                $total_mail_available += $mail->available_mail;
                $total_mail += $mail->total_mail;
            }
        }
        } // Close the if ($user) block

        // For non-logged-in users, allow viewing blogs but no mail functionality
        // if (!$isValidPlan && $user) {
        //     return redirect()->route('pricing')->with('error', 'Please purchase a valid plan first!');
        // }

        // Build API Request
        $APIURL  = $this->APIBASEURL .'/api/blogs/search';
        $response = Http::get($APIURL, [
            'niche' => implode(',', $niches),
            'da_max' => $request->get('da_max'),
            'da_min' => $request->get('da_min'),
            'dr_max' => $request->get('dr_max'),
            'dr_min' => $request->get('dr_min'),
            'traffic_min' => 0,//$request->get('traffic_min'),
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

    public function conversation($id)
{
    $thread = UserMailHistory::with('messages')
        ->where('user_id', Auth::id())
        ->findOrFail($id);

    return view('mail.conversation', compact('thread'));
}
}
