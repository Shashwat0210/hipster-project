<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\UserPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin.login');
    }

    public function showRegister()
    {
        return view('auth.admin.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'email', 'unique:admins,email'],
             'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect('/admin/dashboard');

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();

            UserPresence::updateOrCreate(
                ['user_type' => 'admin', 'user_id' => Auth::guard('admin')->id()],
                ['is_online' => true, 'last_seen_at' =>now()]
            );

            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        $userId = auth('admin')->id();

        Auth::guard('admin')->logout();
        
        UserPresence::where([
            'user_type' => 'admin',
            'user_id' => $userId,
        ])->update([
            'is_online' => false,
            'last_seen_at' => now(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
