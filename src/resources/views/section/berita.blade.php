    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section mt-4 mb-4">
      <div class="container">
        <div class="row">
        <h2 class="text-center mb-4">Berita Populer</h2>
        @foreach ($latestNews as $news)
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="knowledge-item">
              
              <div class="knowledge-content">
                @php
                    $thumbnail = $news->thumbnail
                        ? asset('thumbnails' . $news->thumbnail)
                        : asset('assets/img/default.png');
                @endphp
                <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="Thumbnail"  style="border: 1px solid #f1f1f1;" >
                <h3 class="mt-3"><a href="#">{{ $news->short_title }}</a></h3>
                <div class="trainer d-flex justify-content-between align-items-center">
                    <div class="trainer-profile d-flex align-items-center">
                        <i class="bi bi-calendar2-event me-1"></i> {{ $news->created_at->format('d M Y') }}
                    </div>
                    <div class="trainer-rank d-flex align-items-center">
                        <i class="bi bi-eye eye-icon"></i>&nbsp;{{ $news->views }}
                        &nbsp;&nbsp;
                        <i class="bi bi-people user-icon"></i>&nbsp;0
                        &nbsp;&nbsp;
                        <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                    </div>
                </div>              
              </div>
            </div>
          </div> <!-- End Course Item-->
        @endforeach

          <div class="mt-4 text-center"><a href="/news" class="read-more"><span>Lihat Selengkapnya</span><i class="bi bi-arrow-right"></i></a></div>
        </div>
        
      </div>
    </section>
    <!-- /Knowledges Section -->