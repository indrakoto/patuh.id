@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="container py-5">
    <h2>Selamat datang, {{ $user->name }}</h2>

    @if ($activeMembership)
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Status Keanggotaan Aktif
            </div>
            <div class="card-body">
                <p><strong>Paket:</strong> {{ $activeMembership->membershipPlan->name }}</p>
                <p><strong>Harga:</strong> Rp{{ number_format($activeMembership->membershipPlan->price, 0, ',', '.') }}</p>
                <p><strong>Masa Aktif:</strong> {{ $activeMembership->start_date->format('d M Y') }} s.d. {{ $activeMembership->end_date->format('d M Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-success">Aktif</span>
                </p>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            Anda belum memiliki keanggotaan aktif. Silakan <a href="{{ route('membership.index') }}">berlangganan sekarang</a>.
        </div>
    @endif
</div>
@endsection
