<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\UserMembership;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        try {
            // Validasi Signature Key (opsional tapi direkomendasikan)
            $serverKey = config('midtrans.server_key');
            $json = json_decode($request->getContent(), true);
            $hashed = hash('sha512', $json['order_id'] . $json['status_code'] . $json['gross_amount'] . $serverKey);

            if ($hashed !== $json['signature_key']) {
                Log::warning("Signature Key Mismatch for order_id: {$json['order_id']}");
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Inisialisasi notifikasi Midtrans
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;

            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                Log::warning("Payment not found for order_id: {$orderId}");
                return response()->json(['message' => 'Payment not found'], 404);
            }

            // Simpan log notifikasi
            PaymentLog::create([
                'payment_id' => $payment->id,
                'event_type' => $transactionStatus,
                'payload' => json_encode($notification),
            ]);

            // Update status pembayaran
            $payment->update([
                'payment_status' => $transactionStatus,
                'payment_type' => $notification->payment_type ?? null,
                'payment_method' => $notification->va_numbers[0]->bank
                    ?? ($notification->permata_va_number ?? $notification->payment_type),
                'paid_at' => in_array($transactionStatus, ['settlement', 'capture']) ? now() : null,
            ]);

            // Hanya buat user_membership jika belum pernah dibuat dan pembayaran berhasil
            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $alreadyHasMembership = UserMembership::where('user_id', $payment->user_id)
                    ->where('membership_plan_id', $payment->membership_plan_id)
                    ->where('is_active', true)
                    ->exists();

                if (!$alreadyHasMembership) {
                    UserMembership::create([
                        'user_id' => $payment->user_id,
                        'membership_plan_id' => $payment->membership_plan_id,
                        'start_date' => Carbon::now(),
                        'end_date' => Carbon::now()->addYear(),
                        'is_active' => true,
                    ]);
                }
            }

            return response()->json(['message' => 'Webhook processed successfully']);
        } catch (\Exception $e) {
            Log::error("Midtrans webhook error: " . $e->getMessage());
            return response()->json(['message' => 'Webhook error'], 500);
        }
    }
}
