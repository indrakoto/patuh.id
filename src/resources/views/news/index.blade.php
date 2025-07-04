@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
  
<section id="analisis" class="analisis section">
  @include('section.page-title')
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          @foreach($newsList as $news)
            <div class="col-lg-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
              <div class="analisis-item mb-4">
                <div class="analisis-content">
                  @php
                      $thumbnail = $news->thumbnail 
                          ? asset('thumbnails/' . $news->thumbnail)
                          : asset('img/default.png');
                  @endphp
                  <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="Thumbnail"  style="border: 1px solid #f1f1f1;" >
                  
                  <h3 class="mt-3"><a href="{{ route('news.show', ['news_slug' => $news->slug, 'id' => $news->id]) }}">{{ $news->short_title }}</a></h3>

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
                    <div class="row">
                        <div class="mt-4">
                        </div>
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
