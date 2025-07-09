    <form class="page-title__search" action="{{ route('peraturan.search') }}" method="GET">
        @csrf
        <div class="page-title__search-group">
          <input 
            type="text" 
            class="page-title__search-input" 
            placeholder="Cari Peraturan" 
            name="q"
            aria-label="Search articles"
            value="{{ old('q', $searchQuery ?? '') }}"
            autocomplete="off"
          >
          <button class="page-title__search-btn" type="submit" aria-label="Submit search">
            Telusuri
          </button>
        </div>
      </form>