<!-- Page Heading -->
<header class="bg-white w-100">

    @if(getSetting('enable_top_banner') == 'on')
    <div class="top-banner">
        <div id="carousel" class="carousel slide" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            @for($i = 1; $i <= count(getBanner('top')); $i++)
              <li data-target="#carousel" data-slide-to="{{$i}}" @if($i == 1)class="active"@endif></li>
            @endfor
            </ol>
            <div class="carousel-inner">
            @foreach(getBanner('top') as $banner)
              <div class="carousel-item @if($loop->first) active @endif" data-interval="5000">
                <a href="{{$banner->link}}">
                    <img src="{{ asset($banner->image) }}" class="d-block w-100 top-banner" height="120" alt="{{$banner->name}}" style="object-fit: cover"/>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{$banner->name}}</h5>
                    </div>                            
                </a>
              </div>
              @endforeach
            </div>
            
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>                
    </div>
    @endif

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="{{asset('/assets/images/logo.png')}}"
                class="d-inline-block align-top" alt="" loading="lazy" width="48" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form class="form-inline mt-2 mr-2" method="GET" action="{{route('search')}}">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="keyword" placeholder="Nh???p s???n ph???m c???n t??m"
                                aria-label="Nh???p s???n ph???m c???n t??m" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="ri-search-line"></i></span>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{asset('/page/Tuyen_dung')}}"><i class="ri-volume-up-line"></i> Tuy???n d???ng</a>
                </li>
                @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="{{route('user.dashboard')}}"><i class="ri-user-line"></i> {{Auth::user()->email}}</a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="ri-user-line"></i> T??i kho???n</a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{route('login')}}">????ng nh???p</a>
                      <a class="dropdown-item" href="{{route('register')}}">????ng k??</a>
                      <a class="dropdown-item" href="{{route('password.request')}}">Qu??n m???t kh???u</a>
                    </div>
                  </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cart')}}"><i class="ri-shopping-cart-line"></i> Gi??? h??ng</a>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar navbar-expand-sm navbar-light bg-light border-top border-bottom p-0">
        <button class="navbar-toggler my-2 mx-2" type="button" data-toggle="collapse" data-target="#navbarSubMenu"
            aria-controls="navbarSubMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>            
        <div class="collapse navbar-collapse mx-2" id="navbarSubMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center @if(request()->routeIs('home')){{'active'}}@endif" href="{{ asset('') }}"><i class="ri-home-line mr-1"></i> Trang ch???</a>
                </li>                    
                @foreach(getMenus() as $menu)
                        @if(count($menu['sub_menus']) <= 0)
                            <li class="nav-item">
                                <a class="nav-link @if(request()->path() == getSlug('parent', $menu)){{'active'}}@endif" href="{{ asset(getSlug('parent', $menu)) }}">{{$menu['name']}}</a>
                            </li>                                          
                        @else
                            @if($menu['type'] == 'product')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="menu_{{$menu['id']}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$menu['name']}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="menu_{{$menu['id']}}">
                                    @foreach($menu['sub_menus'] as $sub_menu)
                                        <a class="dropdown-item" href="{{ asset(getSlug('child', $sub_menu)) }}">{{$sub_menu->name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            @endif
                        @endif
                @endforeach
                @if(Auth::check() && Auth::user()->is_patron == 'yes')
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center @if(request()->routeIs('user.patron')){{'active'}}@endif" href="{{ route('user.patron') }}">?????t h??ng</a>
                </li> 
                @endif
            </ul>
        </div>
        <div class="text-right mr-3">
            <span class="font-weight-bold"><i class="ri-phone-line"></i> {{getSetting('company_phone')}}</span>
        </div>
    </nav>  
</header>