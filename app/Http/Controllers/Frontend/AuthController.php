<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
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
                'phone' => 'required|min:8|unique:users,phone',
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

}
