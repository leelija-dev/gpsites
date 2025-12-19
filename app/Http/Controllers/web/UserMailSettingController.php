<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserMailSetting;
use Illuminate\Support\Facades\Auth;

class UserMailSettingController extends Controller
{
    // $id=auth()->id();
    //user mail setting 
public function mailSetting(){
    $emails=UserMailSetting::where('user_id', auth()->id())->get();
    return view('web.user.mail_setting.mail-setting',compact('emails'));
}
public function addMail(){
    return view('web.user.mail_setting.add-mail');
}
public function store(Request $request){
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'name' => 'required|string',
        'smtp_host' => ['required','string','max:255','regex:/^[a-zA-Z0-9.\-]+$/'],
        'smtp_port' => 'required|integer|min:1|max:65535',
        'smtp_encryption' => 'required|in:tls,ssl',
        'password' => 'required|string',
        'email' => 'required|email:rfc,dns|unique:user_mail_setting,email',
    ]);
    if (!empty($data['password'])) {
        $data['password'] = encrypt($data['password']); // or Crypt::encryptString()
    } else {
        unset($data['password']);
    }

    try{
    UserMailSetting::create($data);
    }
    catch(\Exception $e){
        return back()->with('error', $e->getMessage());
    }
    return redirect()->route('mail-setting')->with('success', 'Email added successfully');
}


public function editMail($id){
   
    $data=UserMailSetting::findOrFail(base64_decode($id));
    return view('web.user.mail_setting.edit-mail',compact('data'));
}

public function updateMail(Request $request, $id)
{
    $id = base64_decode($id);
    $data = $request->validate([
        'name' => 'required|string',
        'smtp_host'        => 'required|string',
        'smtp_port'        => 'required|numeric',
        'smtp_encryption'  => 'required|in:tls,ssl',
        'email'            => 'required|email|unique:user_mail_setting,email,' . $id,
        'password'         => 'nullable|string',
    ]);

    $mail = UserMailSetting::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    // Update password only if provided
    if (!empty($data['password'])) {
        $data['password'] = encrypt($data['password']); // or Crypt::encryptString()
    } else {
        unset($data['password']);
    }
try{
    $mail->update($data);
}catch(\Exception $e){
    return redirect()->route('mail-setting')->with('error', $e->getMessage());
}

    return redirect()->route('mail-setting')->with('success', 'Mail data updated successfully.');
}
public function setPrimary(Request $request)
{
    $request->validate([
        'email_id' => 'required|exists:user_mail_setting,id',
        'is_primary' => 'required|boolean',
    ]);

    $email = UserMailSetting::findOrFail($request->email_id);

    if($request->is_primary){
        // Unset primary from all other emails of this user
        UserMailSetting::where('user_id', $email->user_id)
            ->where('id', '!=', $email->id)
            ->update(['is_primary' => 0]);
    } else {
        // Prevent unchecking all — at least one primary
        $otherCount = UserMailSetting::where('user_id', $email->user_id)
            ->where('id', '!=', $email->id)
            ->count();

        if($otherCount == 0){
            $request->is_primary = 1; // keep it primary
        }
    }

    $email->is_primary = $request->is_primary;
    $email->save();

    return response()->json(['success' => true]);
}
public function destroy($id)
{
    try {
        $id = base64_decode($id);
        $email = UserMailSetting::findOrFail($id);
        $email->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Error deleting email: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Unable to delete record'
        ], 500);
    }
}


}
