<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;
class HomeController extends Controller
{
    public function index()
    {
    $response = Http::get(env('API_BASE_URL') .'/api/niches');
       if ($response->successful()) {
        // If your API returns paginated response
        $niches_data = $response->json() ?? [];
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
