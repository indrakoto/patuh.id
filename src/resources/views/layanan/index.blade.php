@extends('layouts.app')

@section('title', 'PatuhID')

@push('styles')
<style>
/* Tombol kustom utama */
.btn-primary-custom {
    background-color: #005b99;
    color: #fff;
    border: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    font-weight: 600;
    border-radius: 9999px; /* rounded-pill */
    padding: 0.6rem 1.2rem;
}

.btn-primary-custom:hover,
.btn-primary-custom:focus {
    background-color: #00416a;
    box-shadow: 0 4px 15px rgba(0, 91, 153, 0.4);
    color: #fff;
    text-decoration: none;
}

/* Border top pengganti <hr> untuk footer card */
.card-footer-border {
    margin-top: 1rem;
    padding-top: 1rem;
}

/* Styling section layanan */
.layanan-section {
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}

.layanan-header {
    font-weight: 700;
    font-size: 1.75rem;
    color: #005b99;
    margin-bottom: 0.5rem;
}

.layanan-content {
    font-size: 1rem;
    color: #333333;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

/* Card highlight untuk plan gratis */
.card.plan-highlight {
    border: 2px solid #005b99;
    background-color: #f7fbff;
    box-shadow: 0 8px 20px rgba(0, 91, 153, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card.plan-highlight:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 91, 153, 0.25);
}

/* Badge Gratis */
.badge-free {
    padding: 0.5em 1rem;
    font-weight: 600;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 128, 0, 0.3);
    font-size: 1.1rem;
}

/* Untuk deskripsi plan supaya konsisten */
.card-body p, .card-body div {
    color: #555;
    font-size: 0.95rem;
    min-height: 100px; /* menjaga card balance */
}

/* Responsive */
@media (max-width: 576px) {
    .card-body p, .card-body div {
        min-height: auto;
    }
}

</style>
@endpush

@section('content')
<section id="pricing" class="pricing section py-5 bg-light">
    <div class="container">

        <!-- Header layanan -->
        <div class="layanan-section text-center mb-5">
            <h2 class="layanan-header">LAYANAN PATUH.ID</h2>
            <p class="layanan-content">
                PATUH.ID menampilkan database Peraturan Perundang-undangan yang memuat informasi mengenai jenis, status hubungan antar peraturan, dan statistik peraturan perundang-undangan LK3 di Indonesia.
            </p>
            <p class="layanan-content">
                PATUH.ID bertujuan untuk menyediakan akses mudah dan informasi yang terpercaya mengenai berbagai peraturan LK3 di Indonesia kepada masyarakat umum.
            </p>
        </div>

        <h2 class="text-center fw-bold mb-5">Choose Your Membership Plan</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            @foreach($plans as $plan)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm rounded-4 p-4 d-flex flex-column
                    @if($plan->price == 0) plan-highlight @endif">

                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title fw-bold text-primary text-center">{{ $plan->name }}</h3>
                        <h4 class="card-subtitle mb-3  align-items-baseline gap-2 text-center mt-4">
                            @if($plan->price == 0)
                                <span class="badge-free bg-success">Free</span>
                            @else
                                <sup style="font-size: 0.75rem">Rp.</sup>
                                <span style="font-size:1.75rem; font-weight: 600;">{{ number_format($plan->price, 0, ',', '.') }}</span>
                            @endif
                            <small class="text-muted">/ year</small>
                        </h4>

                        <div class="mb-4 mt-4 text-center">
                            {!! $plan->description !!}
                        </div>

                        <div class="card-footer-border mt-auto">
                            @if($plan->price == 0)
                                <form method="POST" action="{{ route('membership.basic.activate') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary-custom w-100">
                                        Activate Now
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('payment.checkout', $plan->id) }}"
                                   class="btn btn-primary-custom w-100">
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
