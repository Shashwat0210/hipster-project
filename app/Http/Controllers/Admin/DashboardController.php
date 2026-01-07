<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPresence;

class DashboardController extends Controller
{
  public function index()
  {
    $onlineUsers = UserPresence::where('is_online', true)
    ->orderByDesc('last_seen_at')
    ->get();

    return view('admin.dashboard', compact('onlineUsers'));
  }
}