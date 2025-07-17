@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-10">
    <h1 class="text-3xl font-bold text-yellow-500 mb-4">Pembayaran Belum Selesai</h1>
    <p class="text-lg mb-6">Anda belum menyelesaikan proses pembayaran. Silakan coba kembali.</p>
    <a href="{{ route('membership.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
        Kembali ke Halaman Membership
    </a>
</div>
@endsection
