@extends('layouts.app')

@section('title', 'PatuhID')

@push('styles')
<style>
.btn-primary-custom {
    background-color: #005b99;
    color: #fff;
    transition: background-color 0.3s ease;
}
.btn-primary-custom:hover, 
.btn-primary-custom:focus {
    background-color: #00416a;
    box-shadow: 0 4px 15px rgba(0, 91, 153, 0.4);
    color: #fff;
}

/* Pengganti <hr> dengan border-top halus pada section tombol */
.card-footer-border {
    border-top: 1px solid #e0e0e0;
    padding-top: 1rem;
    margin-top: 1rem;
}

/* Style untuk section layanan */
.layanan-header {
    font-weight: 700;
    font-size: 1.75rem; /* agak besar */
    margin-bottom: 0.5rem;
    color: #005b99;
}
.layanan-content {
    font-size: 1rem;
    color: #333333;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.card.plan-highlight {
    border: 2px solid #005b99;
    box-shadow: 0 8px 20px rgba(0, 91, 153, 0.2);
    background-color: #f7fbff;
    transform: translateY(0);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card.plan-highlight:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 91, 153, 0.35);
}

.badge-free {
    padding: 0.5em 1em;
    font-weight: 600;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 128, 0, 0.3);
}

.btn-primary-custom:hover {
    background-color: #0073e6;
    box-shadow: 0 4px 12px rgba(0, 91, 153, 0.5);
}


</style>
@endpush

@section('content')
<section id="pricing" class="pricing section py-5 bg-light">
    <div class="container">

        <!-- Tambahan bagian heading dan konten sebelum title utama -->
        <div class="layanan-section mb-4 text-center">
            <h2 class="layanan-header">LAYANAN PATUH.ID</h2>
            <p class="layanan-content">
                PATUH.ID menampilkan database Peraturan Perundang-undangan yang memuat informasi mengenai jenis, status hubungan antar peraturan, dan statistik peraturan perundangan-undangan LK3 di Indonesia.
            </p>
            <p class="layanan-content">
                PATUH.ID bertujuan untuk menyediakan akses mudah dan informasi yang terpercaya mengenai berbagai peraturan LK3 di Indonesia kepada masyarakat umum.
            </p>
        </div>

        <h2 class="mb-5 text-center fw-bold">Choose Your Membership Plan</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            @foreach($plans as $plan)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 
                    @if($plan->price == 0) bg-white border-primary @else bg-white @endif
                    rounded-4 p-4 d-flex flex-column">

                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title fw-bold text-primary">{{ $plan->name }}</h3>
                        <h4 class="card-subtitle mb-3">
                            @if($plan->price == 0)
                                <span class="badge bg-success fs-5 px-3 py-2">Free</span>
                            @else
                                <sup class="fs-6">Rp.</sup>
                                <span class="fs-3 fw-semibold">{{ number_format($plan->price, 0, ',', '.') }}</span>
                            @endif
                            <small class="text-muted"> / year</small>
                        </h4>

                        <div class="mb-4 mt-auto text-secondary" style="min-height: 100px;">
                            {!! $plan->description !!}
                        </div>

                        <!-- Pengganti <hr> dengan div border-top -->
                        <div class="card-footer-border mt-auto">
                            @if($plan->price == 0)
                                <form method="POST" action="{{ route('membership.basic.activate') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary-custom w-100 fw-semibold rounded-pill py-2">
                                        Activate Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('payment.checkout', $plan->id) }}" 
                                   class="btn btn-primary-custom w-100 fw-semibold rounded-pill py-2">
                                    Checkout
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
