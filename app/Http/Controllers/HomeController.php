<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;

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

        return view('web.home', compact('plans','niches_data'));
    }
}
