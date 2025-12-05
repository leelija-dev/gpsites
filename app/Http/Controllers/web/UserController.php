<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\MailAvailable;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\UserMailHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $APIBASEURL;

    public function __construct()
    {
        $this->APIBASEURL = config('app.api_url');
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Get mail statistics for today
        $availableMailToday = 0;
        $sentMailToday = 0;
        $activePlansCount = 0;
        $totalActivePlans = 0;
        $totalSpent = 0;

        // Get user's mail available records and sum available mail from all valid plans
        $mailAvailableRecords = MailAvailable::where('user_id', $user->id)->get();

        foreach ($mailAvailableRecords as $mail_available_record) {
            // Check if the plan is still valid (similar to BlogController logic)
            $plan_order = PlanOrder::where('id', $mail_available_record->order_id)->first();

            if ($plan_order) {
                $plan = Plan::where('id', $plan_order->plan_id)->first();

                if ($plan) {
                    $expiryDate = Carbon::parse($plan_order->created_at)->addDays($plan->duration);
                    $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate);

                    // Include both trial and paid plans if they're valid and not expired
                    if ($isValid) {
                        $availableMailToday += $mail_available_record->available_mail;
                        $totalActivePlans++; // Count all active plans (trial + paid)

                        // Track paid plans separately for dashboard access
                        if ($plan->id != config('paypal.trial_plan_id')) {
                            $activePlansCount++;
                        }
                    }
                }
            }
        }

        // Get sent mail count for today from user_mail_history table
        $sentMailToday = UserMailHistory::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Calculate total amount spent by user on successful payments
        $totalSpent = (float) PlanOrder::where('user_id', $user->id)
            ->where('status', 'COMPLETED') // Only count successful payments
            ->sum('amount');

        // Get user's mail history (latest 5 for dashboard)
        $mails = UserMailHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get random blogs from API (3-4 blogs)
        $randomBlogs = [];
        try {
            $APPURL = $this->APIBASEURL . '/api/blogs';
            $response = Http::get($APPURL, [
                'page' => 1,
                'per_page' => 10 // Get more blogs to randomize from
            ]);

            if ($response->successful()) {
                $blogsData = $response->json();
                $blogs = $blogsData['data'] ?? [];

                // Shuffle and take 3-4 random blogs
                if (!empty($blogs)) {
                    shuffle($blogs);
                    $randomBlogs = array_slice($blogs, 0, rand(3, 4));
                }
            }
        } catch (\Exception $e) {
            // If API fails, randomBlogs will remain empty array
            $randomBlogs = [];
        }

        return view('web.user.dashboard', compact('availableMailToday', 'sentMailToday', 'mails', 'randomBlogs', 'totalActivePlans', 'activePlansCount', 'totalSpent'));
    }
}
