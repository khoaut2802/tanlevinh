<nav class="navbar bg-light">
<!-- Links -->
<ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" href="{{route('user.dashboard')}}">Quản lý đơn hàng</a>
    </li>
    @if(Auth::check() && Auth::user()->is_patron == 'yes')
    <li class="nav-item">
    <a class="nav-link" href="{{route('user.patrons')}}">Khách quen</a>
    </li>
    @endif
    <li class="nav-item">
    <a class="nav-link" href="{{route('user.profile')}}">Tài khoản</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{route('user.password')}}">Đổi mật khẩu</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{route('logout2')}}">Thoát</a>
    </li>                 
</ul>
</nav>