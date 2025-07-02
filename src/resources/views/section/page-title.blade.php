<div class="page-title" data-aos="fade">
  <div class="container">
    <div class="page-title__wrapper">
      <!-- Breadcrumb -->
      <nav class="breadcrumbs">
        <ol>
          <li><a href="/">Beranda</a></li>
          @php
          // Mendapatkan nama controller tanpa suffix 'Controller'
          $controllerName = strtolower(
              str_replace('Controller', '', 
                  class_basename(request()->route()->getController())
              )
          );
          @endphp 
          <li>{{ ucwords($controllerName) }}</li>
          @php
          if(isset($article->title)) {
            $title = '<li>'.$article->title.'</li>';
          } else if(isset($institusi->name)) {
            $title = '<li>'.$institusi->name.'</li>';
          } else if(isset($analisis->name)) {
            $title = '<li>'.$analisis->name.'</li>';
          } else if(isset($analisis->title)) {
            $title = '<li>'.$analisis->title.'</li>';
          } else if(isset($neraca->analisis->name)) {
            $title = '<li>'.$neraca->analisis->name.'</li>';
            $title .= '<li>'.$neraca->name.'</li>';
          } else {
            $title = "";
          }
          @endphp
          {!! $title !!}
        </ol>
      </nav>
    </div>
  </div>
</div>