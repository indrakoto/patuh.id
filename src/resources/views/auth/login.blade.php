@extends('layouts.app')  {{-- atau layout yang Anda gunakan --}}

@section('title', 'Login Pengguna')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush

@section('content')
<!-- Forum Section -->
<section id="about" class="about section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('assets/img/logo-patuhid.png') }}" class="" height="150px" alt="Patuh.ID">
                <div class="mt-4" style="text-align: justify;">
                <p>Website PATUH.ID menampilkan database Peraturan Perundang-undangan yang memuat informasi mengenai jenis, status hubungan antar peraturan, dan statistik peraturan perundangan-undangan LK3 di Indonesia.</p>
                <p>PATUH.ID bertujuan untuk menyediakan akses mudah dan informasi yang terpercaya mengenai berbagai peraturanLK3 di Indonesia kepada masyarakat umum.</p>

                <p>Akses mudah : Memberikan akses mudah dan cepat terhadap informasi hukum yang terbaru dan terpecaya.</p>
                </div>
            </div>

<div class="col-lg-6">
    <div class="card border-0 shadow-sm rounded-3" style="background-color: #f8f9fa;">
        <div class="card-body p-4 p-md-5">
            <!-- Logo dan Judul -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/icon-patuhid.png') }}" alt="Logo" height="60" class="mb-3">
                <h3 class="fw-bold">Login ke akun Anda</h3>
                <p class="text-muted">Masukkan email dan password untuk mengakses dashboard</p>
            </div>
            
    <!-- Notifikasi -->
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" 
                            placeholder="contoh@email.com"
                            required 
                            autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Masukkan password"
                            required>
                        <button class="btn btn-outline-secondary toggle-password" type="button">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="/forgot-password" class="text-decoration-none">Lupa Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </button>

                <!-- Register Link -->
                <div class="text-center mb-3">
                    <p class="text-muted">Belum punya akun? 
                        <a href="/registrasi" class="text-decoration-none fw-semibold">Daftar Sekarang</a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="text-center">
                    <a href="/" class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<!-- Toggle Password Visibility Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Temukan semua tombol toggle password
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    // Loop melalui setiap tombol
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Cari input password terkait (prev sibling)
            const passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
            const icon = this.querySelector('i');
            
            if (passwordInput) {
                // Toggle tipe input
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                
                // Toggle icon
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            }
        });
    });
});
</script>
@endpush
        </div>


    </div>
</section>

@endsection
