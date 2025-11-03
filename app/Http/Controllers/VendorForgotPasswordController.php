<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\VendorResetPasswordMail;


class VendorForgotPasswordController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('vendor.auth.forgot-password');
    }

    // Handle form submission
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Send email
$resetLink = url('/vendor/reset-password/' . $token . '?email=' . urlencode($request->email));

try {
    Mail::html('
        <p>Hello,</p>
        <p>Click the button below to reset your password:</p>
        <p style="text-align:center; margin:20px 0;">
            <a href="' . $resetLink . '" style="background:#8D85EC; padding:10px 15px; color:white; text-decoration:none; border-radius:5px;">
                Reset Password
            </a>
        </p>
        <p>If you did not request a password reset, ignore this email.</p>
    ', function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Vendor Password Reset');
    });

    return response()->json(['status' => 'Password reset link sent to your email.']);

} catch (\Exception $e) {
    return response()->json(['error' => 'Failed to send email. Please try again later.'], 500);
}
    }


    // Show reset password form
public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
        'token' => 'required'
    ]);

    $reset = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$reset) {
        return back()->withErrors(['email' => 'Invalid token or email']);
    }

    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    DB::table('password_resets')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('status', 'Password reset successfully!');

}


    public function checkCurrentPassword(Request $request)
    {
        $user = auth()->user(); // or get vendor by email

        if (!$user) {
            return response()->json(['valid' => false]);
        }

        $isValid = Hash::check($request->current_password, $user->password);

        return response()->json(['valid' => $isValid]);
    }
    // Show reset password form
public function showResetForm(Request $request, $token)
{
    $email = $request->query('email'); // Get email from query string
    return view('vendor.profile.reset-password', compact('token', 'email'));
}

}
