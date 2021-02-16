 <!-- Footer -->
 <footer class="bg-white">
    <div class="container py-5">
      <div class="row py-4">
        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
          <div>
            <h6 class="title">{{getSetting('company_name')}}</h6>
            <p class="text-muted">
                Email: <strong>{{getSetting('company_email')}}</strong><br>
                Địa chỉ: <strong>{{getSetting('company_address')}}</strong><br>
                Điện thoại: <strong>{{getSetting('company_phone')}}</strong><br>
                MST: <strong>{{getSetting('mst')}}</strong><br>
            </p>
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
          <h6 class="title">Sản phẩm</h6>
          <ul class="list-unstyled mb-0">
            @foreach(getMenus() as $menu)
                @if($menu['type'] == 'product')
                    <li class="mb-2"><a href="{{asset(getSlug('parent',$menu))}}" class="text-muted">{{$menu['name']}}</a></li>           
                @endif                             
            @endforeach
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
          <h6 class="title">Khách hàng</h6>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><a href="{{route('login')}}" class="text-muted">Đăng nhập</a></li>
            <li class="mb-2"><a href="{{route('register')}}" class="text-muted">Đăng ký</a></li>
            <li class="mb-2"><a href="{{route('cart')}}" class="text-muted">Giỏ hàng</a></li>
            <li class="mb-2"><a href="{{asset('/page/Lien_he')}}" class="text-muted">Liên hệ</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
            <h6 class="title">Chính sách</h6>
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