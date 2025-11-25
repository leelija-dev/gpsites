<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
 public function store(Request $request){
  $data=$request->validate([
    'name'=>'string|required',
    'email'=>'email|required',
    'phone'=>'string|nullable',
    'subject'=>'string|nullable',
    'message'=>'string|nullable',
    
  ]);
  $store=Contact::create($data);
  if($store){
  return redirect()->route('contact')->with('success','Message sent successfully');
  } 
  return back()->with('error', 'Something went wrong, please try again.');
}
}
