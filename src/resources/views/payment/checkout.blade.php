@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-5">
    <h2>Checkout: {{ $plan->name }}</h2>
    <p>Harga: <strong>Rp{{ number_format($plan->price, 0, ',', '.') }}</strong></p>
    <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('payment.finish') }}";
            },
            onPending: function(result) {
                window.location.href = "{{ route('payment.unfinish') }}";
            },
            onError: function(result) {
                window.location.href = "{{ route('payment.error') }}";
            }
        });
    });
</script>
@endpush
