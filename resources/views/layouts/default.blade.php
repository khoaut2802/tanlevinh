<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    </head>
    <body class="bg-gray">
        <div class="container p-0">
            <!-- Page Heading -->
            <header class="bg-white w-100">
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
                                <form class="form-inline mt-2 mr-2">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="Recipient's username"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="ri-search-line"></i></span>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="ri-volume-up-line"></i> Tuyển dụng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}"><i class="ri-user-line"></i>  Đăng nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="ri-shopping-cart-line"></i> Giỏ hàng</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav class="navbar navbar-expand-sm navbar-light bg-light border-top border-bottom border-dark p-0">
                    <button class="navbar-toggler my-2" type="button" data-toggle="collapse" data-target="#navbarSubMenu"
                        aria-controls="navbarSubMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>            
                    <div class="collapse navbar-collapse" id="navbarSubMenu">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ asset('') }}"><i class="ri-home-line mr-1"></i> Trang chủ</a>
                            </li>                    
                            @foreach(getMenus() as $menu)
                                @if(empty($menu['sub_menus']))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ asset($menu['slug']) }}">{{$menu['name']}}</a>
                                    </li>                                          
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="menu_{{$menu['id']}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$menu['name']}}
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="menu_{{$menu['id']}}">
                                            @foreach($menu['sub_menus'] as $sub_menu)
                                                <a class="dropdown-item" href="{{ asset($sub_menu->slug) }}">{{$sub_menu->name}}</a>
                                            @endforeach
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </nav>  
            </header>

            <div class="main-banner my-2">
                <img src="{{ asset(getBanner('main')) }}" class="img-fluid" width="100%" height="auto"/>
            </div>

            <!-- Page Content -->
            <main class="mt-2">
                {{ $slot }}
            </main>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    </body>
</html>
