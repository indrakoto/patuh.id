<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\MidtransService;
use Midtrans\Snap;
use App\Models\UserMembership;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::all();
        //return view('membership.index', compact('plans'));
        return view('layanan.index', compact('plans'));
    }

    public function plans()
    {
        $plans = MembershipPlan::all();
        //return view('membership.plans', compact('plans'));
        return view('layanan.index', compact('plans'));
    }


    public function activateBasic(Request $request)
    {
        $user = $request->user();

        $plan = MembershipPlan::where('id', 1)->where('price', 0)->firstOrFail();

        // Cek apakah user sudah punya keanggotaan aktif
        $already = $user->memberships()
            ->where('membership_plan_id', $plan->id)
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->exists();

        if ($already) {
            return redirect()->back()->with('error', 'Anda sudah memiliki plan Basic yang aktif.');
        }

        //dd($plan);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'order_id' => 'FREE-' . uniqid(),
                'price' => 0,
                'payment_status' => 'paid',
                'paid_at' => now(),
                'payload' => json_encode([
                    'note' => 'Aktivasi manual Plan Basic tanpa pembayaran',
                    'user_id' => $user->id,
                    'timestamp' => now(),
                ]),
            ]);

            $membership = UserMembership::create([
                'user_id' => $user->id,
                'membership_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'is_active' => true,
            ]);
            

            PaymentLog::create([
                'payment_id' => $payment->id,
                'event_type' => 'manual.basic_plan',
                'payload' => json_encode([
                    'note' => 'Aktivasi manual Plan Basic tanpa pembayaran',
                    'user_id' => $user->id,
                    'timestamp' => now(),
                ]),
            ]);

            DB::commit();
            //return redirect()->back()->with('success', 'Plan Basic berhasil diaktifkan!');
            return redirect('/dashboard')->with('success', 'Plan Basic berhasil diaktifkan!');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return redirect()->back()->with('error', 'Gagal mengaktifkan plan Basic.');
        }
    }

}

