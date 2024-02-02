<nav class="nav flex-column">
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid - Cato the Younger -->
    @foreach ($list as $row)
    <a class="nav-link {{ $isActive($row['label']) ? 'active' : ''  }}" href="#">
        {{$row['label']}}
    </a>
    @endforeach
</nav>