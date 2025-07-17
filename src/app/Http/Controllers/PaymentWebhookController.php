<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\UserMembership;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $status = $payload['transaction_status'] ?? 'pending';

        // Logging debug (opsional)
        Log::info('Webhook received: ', $payload);

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update status payment
        $payment->update([
            'payment_type' => $payload['payment_type'] ?? null,
            'payment_method' => $payload['va_numbers'][0]['bank'] ?? null,
            'payment_status' => $status,
            'payload' => $payload,
        ]);

        // Simpan log event
        PaymentLog::create([
            'payment_id' => $payment->id,
            'event_type' => $status,
            'payload' => json_encode($payload),
        ]);

        // Hanya buat membership jika statusnya settlement atau capture (success)
        if (in_array($status, ['settlement', 'capture'])) {
            $userId = $this->resolveUserIdFromPayload($payload);

            // Nonaktifkan membership lama
            UserMembership::where('user_id', $userId)->update(['is_active' => false]);

            // Buat keanggotaan baru
            UserMembership::create([
                'user_id' => $userId,
                'membership_plan_id' => $payment->membership_plan_id,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'is_active' => true,
            ]);
        }

        return response()->json(['message' => 'Webhook processed']);
    }

    protected function resolveUserIdFromPayload($payload): int
    {
        // Contoh: custom field 'user_id' dari Snap payload jika Uda kirim manual
        // Kalau tidak ada, Uda bisa mapping lewat order_id → cari dari tabel payment/user
        $orderId = $payload['order_id'];
        $payment = Payment::where('order_id', $orderId)->first();

        // Pastikan payment ketemu dan user bisa ditelusuri
        return $payment?->membershipPlan?->userMemberships()
            ->latest()
            ->first()
            ->user_id ?? 1; // default fallback (HARUS diganti dengan cara yang pasti)
    }
}
