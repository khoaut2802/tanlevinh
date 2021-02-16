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
            @include('components.header')
            
            <!-- Page Content -->
            <div class="dot-line"></div>
            <section class="mt-2">
                {{ $slot }}
            </section>
            <div class="dot-line"></div>

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

            @include('components.footer')
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
