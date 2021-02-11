<x-default-layout>
    <div class="my-2 row justify-content-center mr-0 ml-0" id="main-div">
    <div class="col-12 my-2">
        <h3>Giỏ hàng:</h3>
    </div>
    </div>
    @php
        $provisional = 0;
        $discount = 0;
    @endphp
    <div class="row mr-0 ml-0">
        @if(session('cart'))
        <aside class="col-lg-9">
            <div class="card">
                <table class="table table-borderless table-shopping-cart">
                    <thead class="text-muted">
                        <tr class="small text-uppercase">
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" width="120">Số lượng</th>
                            <th scope="col" width="120">Giá</th>
                            <th scope="col" class="text-right" width="150"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $key => $item)
                        @php
                            $provisional = $provisional + $item['total_amount'] * $item['quantity'];
                        @endphp
                        <tr>
                            <td>
                                <figure class="itemside align-items-center">
                                    <div class="aside">
                                        <img src="{{asset($item['image'])}}"
                                          class="img-sm">
                                    </div>
                                    <figcaption class="info">
                                        <a href="#" class="title text-dark">{{$item['product_name']}}</a>
                                        <p class="text-muted small">
                                            @foreach($item['attrs'] as $attr)
                                                <span>{{$attr['name']}}: <strong>{{ $attr['values']['name'] }}</strong> giá <strong>@if(is_numeric($attr['values']['price'])) {{ number_format($attr['values']['price']) }}đ @else {{$attr['values']['price']}} @endif </strong></span></br>
                                            @endforeach
                                        </p>
                                    </figcaption>
                                </figure>
                            </td>
                            <td>
                                <input type="text" class="form-control disabled" value="{{$item['quantity']}}" readonly>
                            </td>
                            <td>
                                <div class="price-wrap">
                                    <var class="price">{{number_format($item['total_amount'] * $item['quantity'])}}đ</var>
                                </div> <!-- price-wrap .// -->
                            </td>
                            <td class="text-right">
                                <form method="POST" action="{{route('cart.delete', ['item' => $key])}}">
                                    @csrf
                                <button type="submit" class="btn btn-light"> Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-body border-top">
                    <p class="icontext"><i class="icon text-success fa fa-truck"></i> Tổng cộng {{count(session('cart')) ?? 0}} sản phẩm trong giỏ hàng.</p>
                </div> <!-- card-body.// -->

            </div> <!-- card.// -->

        </aside> <!-- col.// -->
        <aside class="col-lg-3">

            <div class="card mb-3">
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>Bạn có mã giảm giá?</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="" placeholder="Nhập mã giảm giá vào đây">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div> <!-- card-body.// -->
            </div> <!-- card.// -->

            <div class="card">
                <div class="card-body">
                    <dl class="dlist-align">
                        <dt>Tạm tính:</dt>
                        <dd class="text-right">{{number_format($provisional)}}đ</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Giảm giá:</dt>
                        <dd class="text-right text-danger">-0</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Tổng cộng:</dt>
                        <dd class="text-right text-dark b"><strong>{{number_format($provisional + $discount)}}</strong></dd>
                    </dl>
                    <hr>
                    @if(Auth::check())
                    <form method="POST" action="{{route('user.order.create')}}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block"> Tiến hành đặt hàng</button>
                    </form>
                    @else
                        <a href="{{route('login', ['return' => 'cart'])}}" class="btn btn-primary btn-block"> Tiến hành đặt hàng</a>
                    @endif
                    <a href="{{route('home')}}" class="btn btn-light btn-block mt-2">Mua thêm sản phẩm</a>
                </div> <!-- card-body.// -->
            </div> <!-- card.// -->

        </aside> <!-- col.// -->
        @else
            <div class="col-12">
                <div class="alert alert-info">Bạn chưa có sản phẩm nào trong giỏ hàng.</div>
            </div>
        @endif
        </div>
        </div>
    
    <x-slot name="script">
        <script>
            $('.card-attr').on('click', function() {
                var id = $(this).attr('data-attr');
                var price = $(this).attr('data-price');
                var option = $(this).attr('data-option');

                $('.card-attr').each(function() {
                    if($(this).attr('data-attr') == id)
                        $(this).removeClass('active')
                })

                $(this).addClass('active');
                $('input[name="attr_'+id+'"]').val(option)
            })
        </script>
    </x-slot>
</x-default-layout>
