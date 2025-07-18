@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
<section id="courses-courses-details" class="courses-course-details section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                  <h3 class="mb-2">{{ $peraturan->title }}</h3>
                  <div style="border: 1px solid #cccccc; padding:5px;">
                    @php
                        $thumbnail = $peraturan->thumbnail_path 
                            ? asset('document/thumbnails' . $peraturan->thumbnail_path)
                            : asset('img/default.png');
                    @endphp
                    
                    <div class="ratio ratio-16x9 mb-4">
                      <img src="{{ $thumbnail }}" class="" alt="{{ $peraturan->title }}">
                    </div>
                  </div>
                    <div class="course-info d-flex justify-content-between align-items-center">
                        <div class="info-profile d-flex align-items-center">
                          Kategori: {{ $peraturan->categories->name }}
                        </div>
                        <div class="course-info-rank d-flex align-items-center">
                          @php
                          if($peraturan->is_public) {
                            $status = "Open Access";
                          } else{
                            $status = "Private";
                          }
                          @endphp
                          <i class="bi bi-eye eye-icon"></i>&nbsp; {{ $status }} 
                        </div>
                    </div>
                    <hr>
                    <div>Deskripsi :</div>    
                    {!! $peraturan->description !!}                 
              
            </div>


          <div class="col-lg-4">

            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Kategori</h5>
              <p><a href="#">{{ $peraturan->categories->name }}</a></p>
            </div>

            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Ukuran File</h5>
              <p>1 MB</p>
            </div>

            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Tipe File</h5>
              <p>PDF</p>
            </div>

            @php
                use Illuminate\Support\Facades\Crypt;
                $token = Crypt::encrypt(['id' => $peraturan->id, 'slug' => $peraturan->slug]);
            @endphp

            @auth
                @if ($userHasAccess)
                  <div class="course-info d-flex justify-content-between align-items-center">
                    <h5>Download File</h5>
                    <p><a href="{{ route('peraturan.download.token', ['token' => $token]) }}">Download</a></p>
                  </div>
                @else
                    <div class="alert alert-warning mt-2">
                        Dokumen ini berbayar. Silakan daftarkan <a href="{{ route('layanan.index') }}">Layanan</a> untuk mengaksesnya. 
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    Login untuk download
                </a>
            @endauth



            <br/>
            <!-- Search Section -->
            @include('section.search-peraturan')
                

          </div>

        </div>
     
    </div>
</section>
@endsection
