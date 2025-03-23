<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()){
            return redirect()->route('user.dashboard');
        }
        if ($request->isMethod('post')){

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' =>$request->password], $request->remember)){

                if (Auth::user()->status == 0){
                    Auth::logout();
                    throw ValidationException::withMessages(['email' => 'Your account has been blocked. Please contact on Admin.']);
                }
                return redirect()->intended(route('user.dashboard'));
            }else{
                throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
            }

        }
        return view('frontend.auth.login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')){

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|min:8|unique:users,phone',
                'refer_code' => 'nullable',
                'password' => 'required|string|min:8|max:32|confirmed',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            if ($request->refer_code != ''){
                $refer_user = User::where('refer_code', $request->refer_code)->first();
                if ($refer_user != null){
                    $user->refer_by = $refer_user->id;
                }
            }

            $user->save();

            Auth::login($user, true);

            notify()->success('Registration successful');
            return redirect()->intended(route('user.dashboard'));

        }
        return view('frontend.auth.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgot_password(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            $user = User::where('email', $email)->first();
            if ($user == null){
                throw ValidationException::withMessages(['email' => 'Sorry, we couldn\'t find an account with that email address. Please check the email and try again.']);
            }

            $user->otp = generateUniqueCode();
            $user->update();

            Mail::to($user->email)->send(new ForgotPassword($user));

            $msg = 'Password reset email has been sent! Please check your inbox and follow the instructions to reset your password.';
            return redirect()->back()->with('success', $msg);

        }
        return view('frontend.auth.forgot_password');
    }

    public function reset_password($otp, Request $request)
    {
        $otp = Crypt::decrypt($otp);
        if ($otp == ''){
            return redirect('/');
        }

        $user = User::where('otp', $otp)->first();
        if ($user == null){
            abort(404);
        }

        if ($request->isMethod('post')){

            $request->validate([
                'password' => 'required|string|min:8|confirmed', // 'confirmed' will look for 'new_password_confirmation'
            ]);

            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->update();

            notify()->success('Password reset successfully');
            return redirect()->route('login');

        }

        return view('frontend.auth.reset_password', compact('otp', 'user'));

    }

}
