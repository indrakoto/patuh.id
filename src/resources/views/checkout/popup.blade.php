@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="section">
    <div class="container">
        <h2>Checkout Plan: {{ $plan->name }}</h2>
        <p>Harga: Rp{{ number_format($plan->price) }}</p>

        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </div>
</section>

<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                location.href = "{{ route('payment.finish') }}";
            },
            onPending: function (result) {
                location.href = "{{ route('payment.unfinish') }}";
            },
            onError: function (result) {
                location.href = "{{ route('payment.error') }}";
            }
        });
    });
</script>
@endsection
