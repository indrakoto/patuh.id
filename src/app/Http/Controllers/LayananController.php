<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class LayananController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        return view('layanan.index', compact('plans'));
    }
}
