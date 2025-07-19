<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class LayananController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        return response()->json($plans);
    }
}
