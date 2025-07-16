<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class LayananController extends Controller
{
    public function plans()
    {
        $plans = MembershipPlan::all();
        return view('layanan.index', compact('index'));
    }
    
}
