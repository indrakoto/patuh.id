@extends('layouts.app')

@section('title', 'PatuhID')

@section('content')
<section id="courses" class="courses section">
  
    <div class="container">

        <div class="row">
        @foreach ($peraturan as $item)
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
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
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $peraturan->links() }}
        </div>       
    </div>
</section>
@endsection
