@if(is_string($item))
@if($item == '-')
<li class="dropdown-divider"></li>
@else
<li class="nav-header">{{$item}}</li>
@endif

@else

<li class="nav-item {{ isset($item['submenu']) ? 'has-treeview' : ''}}">
    <a href="{{ isset($item['url']) ? $item['url'] : '#' }}" class="nav-link">
        <i class="nav-icon fas fa-{{ isset($item['icon']) ? $item['icon'] : 'circle-notch' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
        <p>{{$item['text']}}
            @if (isset($item['badge']))
            <span class="badge badge-{{ isset($item['badge_color']) ? $item['badge_color'] : 'primary' }} right">{{ $item['badge'] }}</span>
            @elseif (isset($item['submenu']))
            <i class="right fas fa-angle-left"></i>
            @endif
        </p>
    </a>


    @if(isset($item['submenu']))
    <ul class="nav nav-treeview ml-3">
        @each('partials/menu-items', $item['submenu'], 'item')
    </ul>
    @endif
</li>

@endif