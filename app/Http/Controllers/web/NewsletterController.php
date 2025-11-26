<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller; 
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->to($request->input('redirect_to', url()->previous() ?: route('home')))
                ->withErrors($validator, 'newsletter')
                ->withInput()
                ->with('newsletter_error', 'Please enter a valid email address.');
        }
    
        $redirectTo = $request->input('redirect_to', url()->previous() ?: route('home'));
    
        $newsletter = Newsletter::where('email', $request->email)->first();
        $exists = Newsletter::where('email', $request->email)->exists();
         if ($exists) {
        return back()->with('newsletter_error', 'Email already subscribed!');
        }
        if ($newsletter) {
            if ($newsletter->status === 'unsubscribed') {
                $newsletter->update([
                    'status' => 'subscribed',
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                    'source' => $request->source ?? $newsletter->source,
                ]);
    
                return redirect()->to($redirectTo)
                    ->with('newsletter_success', 'You have been resubscribed to our newsletter!');
            }
    
            return redirect()->to($redirectTo)
                ->with('newsletter_info', 'You are already subscribed to our newsletter.');
        }
    
        Newsletter::create([
            'email' => $request->email,
            'status' => 'subscribed',
            'subscribed_at' => now(),
            'source' => $request->source ?? 'website',
        ]);
    
        return redirect()->to($redirectTo)
            ->with('newsletter_success', 'Thank you for subscribing to our newsletter!');
    }
}