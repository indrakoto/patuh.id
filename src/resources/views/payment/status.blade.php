@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h3 class="mb-4">Status Pembayaran</h3>
            <h4 class="text-success">{{ $status }}</h4>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection
