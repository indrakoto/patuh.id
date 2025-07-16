<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\UserMembership;

class PaymentObserver
{
    public function updated(Payment $payment)
    {
        // Aktifkan membership jika payment sukses
        if ($payment->isDirty('payment_status') && $payment->isSuccessful()) {
            $user = $payment->user;
            
            // Nonaktifkan membership aktif sebelumnya
            UserMembership::where('user_id', $user->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
            
            // Buat membership baru
            UserMembership::create([
                'user_id' => $user->id,
                'membership_plan_id' => $payment->membership_plan_id,
                'start_date' => now(),
                'end_date' => now()->addYear(), // 1 tahun
                'is_active' => true
            ]);
        }
    }
}