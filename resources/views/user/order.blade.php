<x-user-layout>
    @php
        $price = 0;
        $quantity = 0;
        $discount = 0;

        foreach($order->detail as $item) {
            $price = $price + $item->price * $item->quantity;
            $quantity = $quantity + $item->quantity;
            $discount = $discount + $item->discount;
        }
    @endphp   
    <div class="my-2 row">
        <div class="col-12 col-sm-2">
            @include('user.navbar')
        </div>
        <div class="col-12 col-sm-10">
            <article class="card">
                <header class="card-header">
                    <strong class="d-inline-block mr-3">Mã đơn hàng: #{{$order->code}}</strong>
                    <span>Ngày đặt hàng: {{\Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s')}}</span>
                    @if($order->status == 'completed')
                        <span class="badge badge-success">Hoàn tất</span>
                    @elseif($order->status == 'pending')
                        <span class="badge badge-info">Đang chờ xác nhận</span>
                    @elseif($order->status == 'processing')
                        <span class="badge badge-warning">Đang xử lý</span>                        
                    @else
                        <span class="badge badge-danger">Đã hủy</span>
                    @endif
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted">Giao tới</h6>
                            <p><b>{{$order->user->name}}</b> <br>
                                Điện thoại: <b>{{$order->user->phone}}</b> <br>
                                Email: <b>{{$order->user->email}}</b> <br>
                                Địa chỉ: <b>{{$order->user->address}}</b>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Thanh toán</h6>
                            <span class="text-success">
                                <i class="fab fa-lg fa-cc-visa"></i>
                                Chuyển khoản
                            </span>
                            <p>Số tiền: {{number_format($price)}}đ <br>
                                Giảm giá: {{number_format($discount)}}đ <br>
                                <span class="font-weight-bold">Cổng cộng: {{number_format($price + $discount)}}đ </span>
                            </p>
                        </div>
                    </div> <!-- row.// -->
                </div> <!-- card-body .// -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            @foreach($order->detail as $item)
                            <tr>
                                <td width="65">
                                    <img src="{{asset($item->product->image)}}" class="border" width="64px">
                                </td>
                                <td>
                                    <p class="title mb-0">{{$item->product->name}}</p>
                                    <span class="price text-muted small">
                                        @foreach(json_decode($item->product_attrs) as $attr)
                                            {{$attr->name}}: {{$attr->values->name}} ({{number_format($attr->values->price)}}đ)<br>
                                        @endforeach
                                    </span>
                                </td>
                                <td> SL: {{$item->quantity}} </td>
                                <td width="250"> <a href="#" class="btn btn-outline-primary">Tra cứu đơn hàng</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- table-responsive .end// -->
            </article>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });            

            $('#cancelOrder').on('click', function() {
                var id = $(this).attr('data-id');
                swal({
                    title: "Are you sure?",
                    text: "Bạn có chắc sẽ hủy đơn hàng này.",
                    type: "error",
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonText: `Xác nhận`
                }).then((result) => {
                    if(result) {
                        $.ajax({
                            url: "{{route('user.order.cancel')}}",
                            data: {order_code: id},
                            type: 'POST',
                            success: function(msg) {
                                swal({
                                    title: "Congratulations!",
                                    text: "Bạn đã hủy đơn hàng thành công.",
                                    type: "success",
                                    timer: 2000,
                                    showCancelButton: false,
                                    showCloseButton: false,
                                    showConfirmButton: false,
                                    showLoaderOnConfirm: true,
                                    onClose() {
                                        window.location.reload()
                                    }
                                })
                            }
                        });     
                    }
                })                   
            })
        </script>
    </x-slot>
</x-user-layout>