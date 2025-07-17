@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section id="checkout" class="section">
  <div class="container">
    <h2>Checkout Paket: {{ $plan->name }}</h2>
    <p>Harga: <strong>Rp{{ number_format($plan->price) }}</strong></p>
    
    <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
  </div>
</section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        fetch("{{ route('checkout.process', $plan->id) }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            window.snap.pay(data.token, {
                onSuccess: function() {
                    location.reload();
                },
                onPending: function() {
                    location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal: ' + result.status_message);
                }
            });
        });
    });
</script>
@endsection
