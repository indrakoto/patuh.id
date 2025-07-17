@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-10">
    <h1 class="text-3xl font-bold text-red-600 mb-4">Gagal Memproses Pembayaran</h1>
    <p class="text-lg mb-6">Terjadi kesalahan saat memproses pembayaran Anda.</p>
    <a href="{{ route('membership.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
        Coba Lagi
    </a>
</div>
@endsection
