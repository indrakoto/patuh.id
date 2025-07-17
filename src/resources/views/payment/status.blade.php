@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto p-6 bg-white rounded shadow mt-10 text-center">
        <h1 class="text-2xl font-bold mb-4">Status Pembayaran</h1>
        <p class="text-lg text-gray-700 mb-4">
            Pembayaran Anda: <strong>{{ $status }}</strong>
        </p>
        <a href="{{ route('dashboard') }}" class="text-blue-500 underline">Kembali ke Dashboard</a>
    </div>
@endsection
