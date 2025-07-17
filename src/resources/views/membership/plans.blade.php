@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
<section id="pricing" class="pricing section">
    <div class="container">
        <h2 class="mb-4">Choose Your Membership Plan</h2>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row gy-3">
            @foreach($plans as $plan)
            <div class="col-xl-4 col-lg-6">
                <div class="pricing-item featured">
                    @php
                    if($plan->id===1){
                        $price = "Free";
                    } else {
                        $price = "<sup>Rp.</sup> ".$plan->formatted_price;
                    }
                    @endphp
                    <h3>{{$plan->name}}</h3>
                    <h4>{!! $price !!}<span> / year</span></h4>
                    {!! $plan->description !!}
                    <a href="{{ route('payment.checkout', $plan->id) }}" class="btn btn-primary">Checkout</a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection