<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\HomeFaqs;
class HomeController extends Controller
{   
     protected $APIBASEURL;
    public function __construct()
    {   
        $this->APIBASEURL = config('app.api_url');
    }
    public function index()
    {
        $APPURL  = $this->APIBASEURL .'/api/niches';

        $response = Http::get($APPURL);
        
        if ($response->successful()) {
            $niches_data = $response->json() ?? [];
            if (is_array($niches_data)) {
                $hasAll = false;
                foreach ($niches_data as $n) {
                    if (is_array($n) && isset($n['niche_name']) && strtolower($n['niche_name']) === 'all') {
                        $hasAll = true;
                        break;
                    }
                    if (is_object($n) && isset($n->niche_name) && strtolower($n->niche_name) === 'all') {
                        $hasAll = true;
                        break;
                    }
                }
                if (!$hasAll) {
                    array_unshift($niches_data, ['niche_name' => 'all']);
                }
            }
        } else {
            $niches_data = [];
        }
        // print_r($response);die;
        $plans = Plan::with('features')
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();
        $faqs = HomeFaqs::index();
        return view('web.home', compact('plans','niches_data','faqs'));
    }

    public function startTrial(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Do NOT write to DB here. Only switch to trial checkout mode.
        $trialStarted = !$user->is_trial; // eligible if not already used

        // Redirect to checkout with the cheapest active plan
        $plan = \App\Models\Plan::where('is_active', true)->orderBy('price', 'asc')->first();
        if (!$plan) {
            return redirect()->route('home')
                ->with('error', 'No active plan available.');
        }

        // Store plan id in session and redirect to checkout without exposing it in URL
        session(['intent_plan' => $plan->id]);
        return redirect()->route('checkout')
            ->with('trial_mode', true)
            ->with('trial_used', !$trialStarted);
    }

    public function completeTrial(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // If already used trial, block completion
        if ($user->is_trial) {
            return redirect()->route('checkout')
                ->with('trial_mode', true)
                ->with('trial_used', true)
                ->with('error', 'You have already used your trial.');
        }

        // Activate trial now (on complete purchase)
        $user->is_trial = 1;
        $user->valid_trial_date = Carbon::today()->addDays(7);
        $user->save();

        return redirect()->route('checkout.success')->with('trial_completed', true);
    }

    
    public function storeIntentPlan(Request $request)
{
    $request->validate([
        'plan' => 'required|integer|exists:plans,id'
    ]);

    // Store plan in session
    session(['intent_plan' => $request->input('plan')]);

    // Force Laravel to remember /checkout as intended URL
    redirect()->setIntendedUrl(route('checkout'));

    // Then send to login
    return redirect()->route('login');
}

}

