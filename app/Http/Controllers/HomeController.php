<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $response = Http::get(env('API_BASE_URL') .'/api/niches');
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

        return view('web.home', compact('plans','niches_data'));
    }

    public function startTrial(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $user->is_trial = 1;
        // Ensure column exists: valid_trial_date should be a nullable datetime column
        $user->valid_trial_date = Carbon::today()->addDays(7);
        $user->save();

        return back()->with('status', 'Trial activated for 7 days.');
    }
}

