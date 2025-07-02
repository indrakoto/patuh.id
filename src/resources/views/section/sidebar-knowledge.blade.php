<!-- resources/views/components/knowledge-sidebar.blade.php -->
@php
    $isActive = isset($institusi) && ($institusi->id == $item->id || $institusi->parent == $item->id);
    $hasChildren = $item->children->isNotEmpty();
@endphp

<div class="menu-parent-container">
    @if ($hasChildren)
        <div class="menu-parent {{ $isActive ? 'active' : '' }}" 
             onclick="toggleSubMenu('submenu-{{ $item->id }}', this)">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ $item->name }}</span>
                <i class="bi bi-chevron-down menu-arrow"></i>
            </div>
        </div>
        
        <div class="sub-menu-container {{ $isActive ? 'show' : '' }}" id="submenu-{{ $item->id }}">
            @foreach ($item->children as $child)
                @php
                    $isChildActive = isset($institusi) && $institusi->id == $child->id;
                @endphp
                <a href="{{ route('knowledge.institusi', ['institusi_slug' => $child->slug]) }}" 
                   class="sub-menu-item {{ $isChildActive ? 'active' : '' }}">
                    {{ $child->name }}
                </a>
            @endforeach
        </div>
    @else
        <a href="{{ route('knowledge.institusi', ['institusi_slug' => $item->slug]) }}" 
           class="menu-parent {{ $isActive ? 'active' : '' }}">
            {{ $item->name }}
        </a>
    @endif
</div>