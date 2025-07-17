<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout($planId)
    {
        $plan = MembershipPlan::findOrFail($planId);
        $user = Auth::user();

        // Midtrans config
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'ORDER-' . strtoupper(Str::random(10));

        // Buat record pembayaran ke DB (belum sukses, status awal: pending)
        $payment = Payment::create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'order_id' => $orderId,
            'price' => $plan->price,
            'payment_status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $plan->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $plan->id,
                    'price' => $plan->price,
                    'quantity' => 1,
                    'name' => $plan->name
                ]
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
                'unfinish' => route('payment.unfinish'),
                'error' => route('payment.error'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.checkout', compact('snapToken', 'plan'));
    }

    public function finish(Request $request)
    {
        return view('payment.status', ['status' => 'Sukses']);
    }

    public function unfinish(Request $request)
    {
        return view('payment.status', ['status' => 'Tidak Selesai']);
    }

    public function error(Request $request)
    {
        return view('payment.status', ['status' => 'Gagal']);
    }
}
