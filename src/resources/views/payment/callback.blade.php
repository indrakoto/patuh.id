<!-- resources/views/payment/callback.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Status</div>

                <div class="card-body text-center">
                    @if($payment->payment_status == \App\Models\Payment::STATUS_SUCCESS)
                        <div class="alert alert-success">
                            <h4><i class="fas fa-check-circle"></i> Payment Successful!</h4>
                            <p>Your membership has been activated.</p>
                        </div>
                    @elseif($payment->payment_status == \App\Models\Payment::STATUS_PENDING)
                        <div class="alert alert-warning">
                            <h4><i class="fas fa-clock"></i> Payment Pending</h4>
                            <p>Please complete your payment.</p>
                            <a href="{{ $payment->payment_url }}" class="btn btn-primary">Continue Payment</a>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <h4><i class="fas fa-times-circle"></i> Payment Failed</h4>
                            <p>Your payment was not successful.</p>
                        </div>
                    @endif
                    
                    <a href="{{ route('membership.index') }}" class="btn btn-secondary">
                        Back to Membership Plans
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection