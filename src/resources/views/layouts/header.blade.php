@php
  $menus = [
    ['label' => 'Beranda', 'url' => '/'],
    ['label' => 'Berita', 'url' => '/news'],
    ['label' => 'Peraturan', 'url' => '/peraturan'],
    ['label' => 'Layanan', 'url' => '/layanan'],
  ];

  if(Auth::check()) {
    // Siapkan submenu items
    $submenuItems = [
      [
        'label' => '<span><i class="bi bi-house-fill"></i> Dashboard</span>',
        'url' => '#',
        'raw' => true,
      ]
    ];
    
    // Tambahkan menu Admin jika role sesuai
    if (in_array(Auth::user()->role, ['admin', 'teknis'])) {
      $submenuItems[] = [
        'label' => '<i class="bi bi-gear"></i> Admin Page',
        'url' => '/administrator',
        'raw' => true
      ];
    }
    
    // Tambahkan menu Logout
    $submenuItems[] = [
        'label' => '<span class="logout-btn" style="cursor:pointer;display:block;padding:0.5rem 1rem;">
                          <i class="bi bi-box-arrow-right"></i> Logout
                       </span>',
        'url' => 'javascript:void(0)',
        'raw' => true
    ];
    
    // Menu dropdown untuk user yang login
    $menus[] = [
      'label' => '<i class="bi bi-person-fill user-icon"></i>&nbsp;' . Auth::user()->name . ' <i class="bi bi-chevron-down toggle-dropdown"></i>',
      'url' => '#',
      'raw' => true,
      'submenu' => $submenuItems
    ];
    
  } else {
    $menus[] = [
      'label' => 'Masuk <i class="bi bi-box-arrow-right"></i>',
      'url' => '/login',
      'raw' => true,
    ];
  }
@endphp

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <img  height="72px" src="{{asset('assets/img/icon-patuhid.png')}}" /> <h1>patuh.id</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        @foreach ($menus as $menu)
          <li class="{{ !empty($menu['submenu']) ? 'dropdown' : '' }}">
            <a 
              href="{{ $menu['url'] }}" 
              class="{{ request()->is(ltrim($menu['url'], '/')) ? 'active' : '' }} {{ $menu['class'] ?? '' }}">
              {!! $menu['raw'] ?? false ? $menu['label'] : e($menu['label']) !!}
            </a>
            
            @if(!empty($menu['submenu']))
              <ul>
                @foreach($menu['submenu'] as $submenu)
                  @if($submenu) {{-- Skip null items --}}
                    <li>
                      
                        <a href="{{ $submenu['url'] }}">
                          {!! $submenu['raw'] ?? false ? $submenu['label'] : e($submenu['label']) !!}
                        </a>
                      
                      
                    </li>
                  @endif
                @endforeach
              </ul>
            @endif
          </li>
        @endforeach
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
</header>