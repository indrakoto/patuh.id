<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\MidtransService;

class MembershipController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        return view('membership.index', compact('plans'));
    }

    public function plans()
    {
        $plans = MembershipPlan::all();
        return view('membership.plans', compact('plans'));
    }

}

