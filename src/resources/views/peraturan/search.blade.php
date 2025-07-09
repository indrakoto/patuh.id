@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
<section id="courses" class="courses section">
  
    <div class="container">

        <!-- Search Section -->
        <div class="row justify-content-center mb-4">
            @include('section.search-peraturan')
        </div>    

        <div class="row">
<!-- Results -->
            @if($results->count() > 0)
                <div class="alert">
                    Ditemukan {{ $results->total() }} hasil untuk pencarian "{{ $searchQuery }}"
                </div>
                @foreach ($results as $item)
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch aos-init aos-animate mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="course-item">
                        <img src="{{ asset('document/thumbnails'.$item->thumbnail_path) }}" class="img-fluid" alt="Patuh.ID">
                        <div class="course-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="#" class="btn btn-small btn-secondary">{{ $item->categories->name }}</a>
                            <p class=""><i class="bi bi-person user-icon"></i> 0</p>
                        </div>

                        <h3><a href="{{ route('peraturan.show', ['slug' => Str::slug($item->slug), 'id_peraturan' => $item->id]) }}">{{ $item->title }}</a></h3>

                        </div>
                    </div>
                    </div> <!-- End Course Item-->
                @endforeach
            @else
                <div class="alert alert-warning">
                    Tidak ditemukan hasil untuk pencarian "{{ $searchQuery }}"
                </div>
            @endif


        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $results->links() }}
        </div>       
    </div>
</section>
@endsection
