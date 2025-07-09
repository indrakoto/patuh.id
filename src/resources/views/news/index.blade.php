@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
<section id="knowledges" class="knowledges section">
  @include('section.page-title')
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          @foreach($newsList as $news)
            <div class="col-lg-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
              <div class="knowledge-item mb-4">
                <div class="knowledge-content">
                  @php
                      $thumbnail = $news->thumbnail 
                          ? asset('thumbnails/' . $news->thumbnail)
                          : asset('assets/img/default.png');
                  @endphp
                  <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="Thumbnail"  style="border: 1px solid #f1f1f1; padding:0" >
                  
                  <h3 class="mt-2"><a href="{{ route('news.show', ['news_slug' => $news->slug, 'id' => $news->id]) }}">{{ $news->short_title }}</a></h3>

                  <div class="trainer d-flex justify-content-between align-items-center">
                      <div class="trainer-profile d-flex align-items-center">
                          {{ $news->category->name }}
                      </div>
                      <div class="trainer d-flex align-items-center">
                          <i class="bi bi-calendar2-event me-1"></i> {{ $news->created_at->format('d/m/y') }}
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
