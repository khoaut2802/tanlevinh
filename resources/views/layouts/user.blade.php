<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title ?? 'Công ty in ấn giá rẻ, chất lượng'}} - {{ config('app.name', 'Laravel') }}</title>

        <meta name="keywords" content="{{$meta_keyword ?? 'in ấn, in an, thiết kế, thiet ke, công ty, ở, tại, cong ty, o, tai, tp hcm, giá rẻ, gia re.'}}" />
        <meta name="description" content="{{$meta_desc ?? 'Công ty in ấn chất lượng, giá rẻ và uy tín nhất. Giải pháp tiết kiệm chi phí và thời gian đi lại cho quý khách cần in ấn. Nhận đơn hàng in trực tuyến, giao hàng đến tận nơi. Trong nội thành và các tỉnh khác.'}}" /> 
        <meta name="copyright" content="{{getSetting('company_name')}}" />
        <meta name="author" content="{{getSetting('company_name')}}" />
        <meta property="og:site_name" content="{{env('APP_URL')}}" />
        <meta property="og:type" content="website" />
        <meta property="og:locale" content="vi_VN" />        
        <link rel="icon" type="image/ico" href="{{asset('/favicon.ico')}}">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.theme.default.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/datatable/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    </head>
    <body class="bg-gray">
        <div class="container p-0">
            <!-- Page Heading -->
            <header class="bg-white w-100 shadow">

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
                                        <input type="text" class="form-control"  name="keyword" placeholder="Nhập sản phẩm cần tìm"
                                            aria-label="Nhập sản phẩm cần tìm" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="ri-search-line"></i></span>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{asset('/page/Tuyen_dung')}}"><i class="ri-volume-up-line"></i> Tuyển dụng</a>
                            </li>
                            @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.dashboard')}}"><i class="ri-user-line"></i> {{Auth::user()->email}}</a>
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="ri-user-line"></i> Tài khoản</a>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{{route('login')}}">Đăng nhập</a>
                                  <a class="dropdown-item" href="{{route('register')}}">Đăng ký</a>
                                  <a class="dropdown-item" href="{{route('password.request')}}">Quên mật khẩu</a>
                                </div>
                              </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('cart')}}"><i class="ri-shopping-cart-line"></i> Giỏ hàng</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav class="navbar navbar-expand-sm navbar-light bg-light border-top border-bottom border-dark p-0">
                    <button class="navbar-toggler my-2 mx-2" type="button" data-toggle="collapse" data-target="#navbarSubMenu"
                        aria-controls="navbarSubMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>            
                    <div class="collapse navbar-collapse mx-2" id="navbarSubMenu">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center @if(request()->routeIs('home')){{'active'}}@endif" href="{{ asset('') }}"><i class="ri-home-line mr-1"></i> Trang chủ</a>
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
                                <a class="nav-link d-flex align-items-center @if(request()->routeIs('user.patron')){{'active'}}@endif" href="{{ route('user.patron') }}">Đặt hàng</a>
                            </li> 
                            @endif
                        </ul>
                    </div>
                    <div class="text-right mr-3">
                        <span><i class="ri-phone-line"></i> {{getSetting('company_phone')}}</span>
                    </div>
                </nav>  
            </header>
            
            <!-- Page Content -->
            <section class="mt-2">
                {{ $slot }}
            </section>

            <section>
                <h3 class="text-center">Thanh toán Online</h3>
                <p class="text-center">Hỗ trợ thanh toán Online qua các cổng thanh toán trực tuyến.</p>
                <div class="brands">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="brands_slider_container">
                                    <div class="owl-carousel owl-theme brands_slider">
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/onepay.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/vcb.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/vietin.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/donga.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/bidv.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/techcombank.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/hdbank.jpg')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/sacom.jpg')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card brands_item">
                                                <img src="{{asset('/assets/images/exim.jpg')}}" alt="">
                                            </div>
                                        </div>                                                                                                                        
                                    </div> <!-- Brands Slider Navigation -->
                                    <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
                                    <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

  <!-- Footer -->
  <footer class="bg-white">
    <div class="container py-5">
      <div class="row py-4">
        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
          <div class="text-center">
            <img src="{{asset('/assets/images/logo.png')}}" alt="" width="80" class="mb-3">
            <p class="font-italic text-muted">{{getSetting('company_desc')}}</p>
          </div>
          <ul class="list-inline mt-4">
            <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
          <h6 class="text-uppercase font-weight-bold mb-4">Sản phẩm</h6>
          <ul class="list-unstyled mb-0">
            @foreach(getMenus() as $menu)
                @if($menu['type'] == 'product')
                    <li class="mb-2"><a href="{{asset(getSlug('parent',$menu))}}" class="text-muted">{{$menu['name']}}</a></li>           
                @endif                             
            @endforeach
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
          <h6 class="text-uppercase font-weight-bold mb-4">Khách hàng</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><a href="{{route('login')}}" class="text-muted">Đăng nhập</a></li>
            <li class="mb-2"><a href="{{route('register')}}" class="text-muted">Đăng ký</a></li>
            <li class="mb-2"><a href="{{route('cart')}}" class="text-muted">Giỏ hàng</a></li>
            <li class="mb-2"><a href="{{asset('/page/Lien_he')}}" class="text-muted">Liên hệ</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <h6 class="text-uppercase font-weight-bold mb-4">Chính sách</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="{{asset('/page/Hinh_thuc_thanh_toan')}}" class="text-muted">Hình thức thanh toán</a></li>
              <li class="mb-2"><a href="{{asset('/page/Chinh_sach_rieng_tu')}}" class="text-muted">Chính sách riêng tư</a></li>
              <li class="mb-2"><a href="{{asset('/page/Van_chuyen')}}" class="text-muted">Vận chuyển</a></li>
              <li class="mb-2"><a href="{{asset('/page/Doi_tra_va_hoan_tien')}}" class="text-muted">Đổi trả và hoàn tiền</a></li>
            </ul>
          </div>
      </div>
    </div>

    <!-- Copyrights -->
    <div class="bg-light py-4">
      <div class="container text-center">
        <p class="text-muted mb-0 py-2">© 2021 {{getSetting('company_name')}}. All rights reserved.</p>
        <p class="text-muted mb-0 py-2">Made by CMSNT.CO.</p>
      </div>
    </div>
  </footer>
  <!-- End -->  
        </div>

        <!-- Scripts -->
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl-carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
        {{$script ?? ''}}
        <script>
            $('.datatable').DataTable({"autoWidth": true})
            
            if ($('.brands_slider').length) {
                var brandsSlider = $('.brands_slider');

                brandsSlider.owlCarousel({
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    nav: false,
                    dots: false,
                    autoWidth: true,
                    items: 9,
                    margin: 20
                });

                if ($('.brands_prev').length) {
                    var prev = $('.brands_prev');
                    prev.on('click', function () {
                        brandsSlider.trigger('prev.owl.carousel');
                    });
                }

                if ($('.brands_next').length) {
                    var next = $('.brands_next');
                    next.on('click', function () {
                        brandsSlider.trigger('next.owl.carousel');
                    });
                }
            }
        </script>
            <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/60248795918aa261273dc575/1eu7b38m5';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>
