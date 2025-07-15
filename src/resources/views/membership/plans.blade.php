<!-- resources/views/membership/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Choose Your Membership Plan</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        @foreach($plans as $plan)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="text-center">{{ $plan->name }}</h4>
                </div>
                <div class="card-body">
                    <h2 class="text-center">{{ $plan->formatted_price }}</h2>
                    <p>{{ $plan->description }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <form action="{{ route('payment.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="membership_plan_id" value="{{ $plan->id }}">
                        <button type="submit" class="btn btn-primary w-100">Join Now</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection