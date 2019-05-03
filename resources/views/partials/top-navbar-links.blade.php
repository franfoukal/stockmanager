<ul class="navbar-nav">

    @if (is_array($item))
    <li class="nav-item d-none d-sm-inline-block">

        <a href="{{ isset($item['url']) ? $item['url'] : 'index.php' }}" class="nav-link"> 
            @if (isset($item['icon']))
            <i class="{{ isset($item['icon']) ? 'fas fa-'.$item['icon'] : 'index.php' }}"></i>
            @endif 
            {{ isset($item['text']) ? $item['text'] : 'Link' }} </a>
    </li>
    @endif

</ul>