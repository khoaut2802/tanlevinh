 <!-- Footer -->
 <footer class="bg-white">
    <div class="container py-5">
      <div class="row">
        <div class="col-lg-12 col-md-6 mb-4 mb-lg-0">
          <div class="p-3 bg-gradient-light rounded-lg">
            <h5 class="d-block title" style="font-size: 20px !important">{{getSetting('company_name')}}</h5>
            <p class="text-muted" style="font-size: 16px">
                Thời gian làm việc: {{getSetting('company_business_time')}}<br>
                Email: {{getSetting('company_email')}}<br>
                Địa chỉ: {{getSetting('company_address')}}<br>
                Điện thoại: {{getSetting('company_phone')}}<br>
                MST: {{getSetting('mst')}}<br>
            </p>
            <ul class="list-inline mt-4">
              <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="ri-twitter-line"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="ri-facebook-line"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="ri-instagram-line"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="ri-pinterest-line"></i></a></li>
              <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="ri-vimeo-line"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row py-4">
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
          <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
            <h6 class="title">Từ khóa</h6>
            <p>in catalogue, in brochure, in tờ rơi, in tờ gấp, letter head, in decal nhựa, in poster, in túi xách, in vỏ hộp, in hộp giấy giá rẻ, in phun uv, xưởng in offset giá rẻ, uv định hình, bao bì cà phê, bao bì thực phẩm, in tem nhãn, bạt quảng cáo, in hiflex, thiết kế in ấn, in pp ngoài trời, decal cuộn, tem cuộn, in túi giấy giá rẻ tphcm, bao bì pp, in bao bì</p>
          </div>
      </div>
    </div>

    <!-- Copyrights -->
    <div class="bg-light py-4">
      <div class="container text-center">
        <p class="text-muted mb-0 py-2">© 2021 {{getSetting('company_name')}}. All rights reserved.</p>
        <p class="text-muted mb-0 py-2">Made by NXK.</p>
      </div>
    </div>
  </footer>
  <!-- End -->  