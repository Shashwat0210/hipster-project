<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\UserPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.customer.login');
    }

    public function showRegister()
    {
        return view('auth.customer.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect('/customer/dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('customer')->attempt($credentials)){
            $request->session()->regenerate();

            UserPresence::updateOrCreate(
                ['user_type' => 'customer', 'user_id' => Auth::guard('customer')->id()],
                ['is_online' => true, 'last_seen_at' =>now()]
            );


            return redirect('/customer/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        $userId = auth('customer')->id();

        Auth::guard('customer')->logout();

        UserPresence::where([
            'user_type' => 'customer',
            'user_id' => $userId,
        ])->update([
            'is_online' => false,
            'last_seen_at' => now(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/customer/login');
    }
}
