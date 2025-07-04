@extends('layouts.app')

@section('title', 'KMS - Analisis')

@section('content')
  
<section id="analisis" class="analisis section">
  @include('section.page-title')
  
  <div class="container">
  <!-- Dropdown Button Analisis -->
  <div class="mb-3">
    <div class="dropdown d-inline me-2">
      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownAnalisis" data-bs-toggle="dropdown" aria-expanded="false">
        Analisis
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownAnalisis">
        <li><a href="#" class="dropdown-item scroll-to" data-target="analisis-section">Semua Analisis</a></li>
        @foreach($analisisList as $aLi)
          <li><a class="dropdown-item" href="{{ route('detail.show', ['article_slug' => $aLi->slug, 'id' => $aLi->id]) }}">{{ $aLi->short_title }}</a></li>
        @endforeach
      </ul>
    </div>

    <!-- Dropdown Button Layanan Publik -->
    <div class="dropdown d-inline">
      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownLayanan" data-bs-toggle="dropdown" aria-expanded="false">
        Layanan Publik
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownLayanan">
        <li><a href="#" class="dropdown-item scroll-to" data-target="layanan-section">Semua Layanan Publik</a></li>
        @foreach($layananList as $itemLi)
          @if($itemLi->redirect_link==1)
              <li><a class="dropdown-item" href="{{ $itemLi->embed_link }}">{{ $itemLi->short_title }}</a></li>
          @else
              <li><a class="dropdown-item" href="{{ route('detail.show', ['article_slug' => $itemLi->slug, 'id' => $itemLi->id]) }}">{{ $itemLi->short_title }}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>

    <h3 class="mb-3" id="analisis-section">Semua Analisis</h3>
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          @foreach($analisisList as $aList)
            <div class="col-lg-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
              <div class="analisis-item mb-4">
                <div class="analisis-content">
                  <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                  <h3 class="mt-3"><a href="{{ route('detail.show', ['article_slug' => $aList->slug, 'id' => $aList->id]) }}">{{ $aList->short_title }}</a></h3>

                  <div class="box-footer d-flex justify-content-between align-items-center pt-1 pb-1 pr-1 pl-3">
                      <div class="trainer-profile d-flex align-items-center">
                        <!-- isi dengan institusi -->
                      </div>
                      <div class="trainer-rank d-flex align-items-center">
                          <i class="bi bi-eye eye-icon"></i>&nbsp;0
                          &nbsp;&nbsp;
                          <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                      </div>
                  </div>  
                </div>
              </div>
            </div>
          @endforeach
          <!-- Pagination -->
          <div class="mt-4"> 
          </div>
        </div>
      </div>
    </div>

    <h3 class="mb-3" id="layanan-section">Layanan Publik</h3>
    <div class="row">    
        @foreach($layananList as $item)
          <div class="col-lg-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
            <div class="analisis-item mb-4">
              <div class="">
                <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                @if($item->redirect_link==1)
                    <h3 class="mt-3"><a href="{{ $item->embed_link }}">{{ $item->short_title }}</a></h3>
                @else
                    <h3 class="mt-3"><a href="{{ route('detail.show', ['article_slug' => $item->slug, 'id' => $item->id]) }}">{{ $item->short_title }}</a></h3>
                @endif
                <div class="box-footer d-flex justify-content-between align-items-center pt-1 pb-1 pr-1 pl-3">
                    <div class="trainer-profile d-flex align-items-center">
                      <!-- isi dengan institusi -->
                    </div>
                    <div class="trainer-rank d-flex align-items-center">
                        <i class="bi bi-eye eye-icon"></i>&nbsp;0
                        &nbsp;&nbsp;
                        <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                    </div>
                </div>  
              </div>
            </div>
          </div>
        @endforeach
    </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
  // Tangani klik untuk scroll smooth ke section tertentu
  document.querySelectorAll('.scroll-to').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('data-target');
      const targetElement = document.getElementById(targetId);
      if(targetElement) {
        window.scrollTo({ top: targetElement.offsetTop, behavior: 'smooth' });
      }
    });
  });
</script>
@endpush
