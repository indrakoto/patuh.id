@extends('layouts.app')

@section('title', 'Registrasi Pengguna Baru')
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/forum.css') }}">
@endpush

@section('content')
<!-- Forum Section -->
<section id="forum" class="forum section">
    
    @include('section.page-title')
    <div class="container" style="max-width: 400px;">
        <div class="card mb-3 border rounded" style="border-color: #e0e0e0 !important;">
            <div class="card-body p-4">
                <h3>Registrasi Akun Baru</h3>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" 
                            name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mt-4 mb-4">
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </div>
                    <div class="text-center">
                        <a href="/login" class="">back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
