@extends('layouts.app')  {{-- atau layout yang Anda gunakan --}}

@section('title', 'Login Pengguna')
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/forum.css') }}">
@endpush

@section('content')
<!-- Forum Section -->
<section id="forum" class="forum section">
    
    @include('section.page-title')
    <div class="container" style="max-width: 400px;">
        <div class="card mb-4 border rounded" style="border-color: #e0e0e0 !important;">
            <div class="card-body p-4">
                <h3>Login</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                        <div class="col-6">
                            <a href="/registrasi" class="btn btn-success w-100">Registrasi
                            </a>
                        </div>
                    </div>
                    
                    
                </form>
                
            </div>
        </div>

    </div>

</section>

@endsection
