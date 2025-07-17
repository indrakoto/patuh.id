@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-10">
    <h1 class="text-3xl font-bold text-green-600 mb-4">Pembayaran Berhasil</h1>
    <p class="text-lg mb-6">Terima kasih, pembayaran Anda telah berhasil diproses.</p>
    <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
        Lanjut ke Dashboard
    </a>
</div>
@endsection
