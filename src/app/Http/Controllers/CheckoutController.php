<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\MembershipPlan;
use Midtrans\Snap;
use Midtrans\Transaction;

class CheckoutController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'membership_plan_id' => 'required|exists:membership_plans,id',
        ]);

        $plan = MembershipPlan::findOrFail($request->membership_plan_id);

        $orderId = 'ORDER-' . uniqid();

        $payment = Payment::create([
            'membership_plan_id' => $plan->id,
            'order_id' => $orderId,
            'price' => $plan->price,
            'payment_status' => 'pending',
        ]);

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
                'finish' => route('checkout.success'),
            ]
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function success() { return view('checkout.success'); }
    public function unfinish() { return view('checkout.unfinish'); }
    public function error() { return view('checkout.error'); }
    
}