<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'membership_plan_id' => 'required|exists:membership_plans,id'
        ]);

        $plan = MembershipPlan::findOrFail($request->membership_plan_id);
        $user = auth()->user();

        // Buat payment record
        $payment = Payment::create([
            'membership_plan_id' => $plan->id,
            'order_id' => 'MEMB-' . time() . '-' . Str::random(4),
            'price' => $plan->price,
            'payment_status' => Payment::STATUS_PENDING
        ]);

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->price,
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
                    'name' => $plan->name . ' Membership',
                ]
            ],
        ];

        try {
            $snapResponse = $this->midtransService->createTransaction($params);
            
            $payment->update([
                'payment_url' => $snapResponse->redirect_url
            ]);

            return redirect($snapResponse->redirect_url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment gateway error: ' . $e->getMessage());
        }
    }

    public function handleNotification(Request $request)
    {
        $notification = $this->midtransService->handleNotification();

        // Cari payment berdasarkan order_id
        $payment = Payment::where('order_id', $notification->order_id)->firstOrFail();

        // Simpan log notifikasi
        $payment->logs()->create([
            'event_type' => $notification->transaction_status,
            'payload' => $notification
        ]);

        // Update status payment
        $status = $notification->transaction_status;
        $fraud = $notification->fraud_status;

        if ($status == 'capture') {
            if ($fraud == 'challenge') {
                $payment->payment_status = Payment::STATUS_PENDING;
            } else if ($fraud == 'accept') {
                $payment->payment_status = Payment::STATUS_SUCCESS;
            }
        } else if ($status == 'settlement') {
            $payment->payment_status = Payment::STATUS_SUCCESS;
        } else if ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
            $payment->payment_status = Payment::STATUS_FAILED;
        } else if ($status == 'pending') {
            $payment->payment_status = Payment::STATUS_PENDING;
        }

        $payment->save();

        return response()->json(['status' => 'success']);
    }

    public function paymentCallback(Request $request)
    {
        $orderId = $request->order_id;
        $payment = Payment::where('order_id', $orderId)->firstOrFail();

        return view('payment.callback', compact('payment'));
    }
}