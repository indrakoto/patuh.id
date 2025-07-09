@extends('layouts.app')
@section('content')
 
      <section id="knowledges-knowledge-details" class="knowledges-knowledge-details section">
            @include('section.page-title')
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                <h3 class="mb-2">{{ $news->title }}</h3>
                    
                        <div class="knowledge-info d-flex justify-content-between align-items-center">
                            <div class="info-profile d-flex align-items-center">
                              Publikasi: {{ $news->tanggal_indo }}
                            </div>
                            <div class="knowledge-info-rank d-flex align-items-center">
                              <i class="bi bi-eye eye-icon"></i>&nbsp;0
                              &nbsp;&nbsp;
                              <i class="bi bi-person user-icon"></i>&nbsp;50
                              &nbsp;&nbsp;
                              <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;65
                            </div>
                        </div>
                        
                    {!! $news->content !!}                 
                </div>
                <div class="col-lg-3">
                    
                    <div class="mb-4">
                        <!-- Include Search Form -->
                        @include('section.search')
                    </div>

                    <div class="knowledges-knowledge-lainnya">
                        <h3>Berita Lainnya</h3>
                        
                        <div class="">
                            @foreach($relatedNews as $related)
                            <div class="knowledge-lainnya-item mt-4 mb-3 align-items-center">
                                <!-- Kolom untuk thumbnail -->
                                <div class="col-md-12">
                                    @php
                                        $thumbnail = $related->thumbnail 
                                            ? asset('thumbnails/' . $related->thumbnail)
                                            : asset('assets/img/default.png');
                                    @endphp
                                    <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="{{ $related->title }}">
                                </div>
                                
                                <!-- Kolom untuk konten -->
                                <div class="col-md-12">
                                    <h3 class="mt-3 mb-3">
                                        
                                        <a href="{{ route('news.show', ['news_slug' => $related->slug, 'id' => $related->id]) }}">
                                            {{ $related->title }}
                                        </a>
                        
                                    </h3>
                                    <div class="trainer d-flex justify-content-between align-items-center">
                                        <div class="trainer-profile d-flex align-items-center">
                                            <i class="bi bi-calendar2-event me-1"></i>
                                            {{ $related->created_at->format('d M Y') }}
                                        </div>
                                        <div class="trainer-rank d-flex align-items-center">
                                            <i class="bi bi-eye me-1"></i>
                                            {{ $related->views }}
                                            
                                                &nbsp;&nbsp;
                                                <i class="bi bi-people user-icon"></i>&nbsp;0
                                                &nbsp;&nbsp;
                                                <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>

        </section><!-- /Courses Section -->
@endsection


