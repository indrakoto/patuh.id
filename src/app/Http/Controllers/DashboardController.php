<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMembership;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activeMembership = UserMembership::with('membershipPlan')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        return view('user.dashboard', compact('user', 'activeMembership'));
    }
}
