<x-user-layout>
    <div class="my-2 row">
        <div class="col-12 col-sm-2">
            @include('user.navbar')
        </div>
        <div class="col-12 col-sm-10">
            <div class="card">
                <div class="card-header">Quản lý đơn hàng</div>
                <div class="card-body">
                    <div class="group-tabs">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item"><a class="nav-link active" href="#pending_orders" aria-controls="pending_orders" role="tab" data-toggle="tab">Đơn hàng đang chờ</a></li>
                          <li class="nav-item"><a class="nav-link" href="#processing_order" aria-controls="processing_order" role="tab" data-toggle="tab">Đơn hàng đang xử lý</a></li>
                          <li class="nav-item"><a class="nav-link" href="#completed_order" aria-controls="completed_order" role="tab" data-toggle="tab">Đơn hàng đã hoàn tất</a></li>
                        </ul>
                  
                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                          <div role="tabpanel" class="tab-pane active" id="pending_orders">
                              <div class="table-responsive">
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Khuyến mãi</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pending_orders as $order)
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
                                    <tr>
                                        <th scope="row" style="font-size: 12px;">{{$order->id}}</th>
                                        <td style="font-size: 12px;">
                                            @foreach($order->detail as $item)
                                                <p>{{$item->product->name}}</p>
                                            @endforeach                                                
                                        </td>
                                        <td>
                                            {{number_format($price)}}đ
                                        </td>
                                        <td>
                                            {{$quantity}}
                                        </td>
                                        <td>
                                            {{number_format($discount)}}đ
                                        </td>                                            
                                        <td>{{number_format($price + $discount)}}đ</td>
                                        <td><button type="buttom" class="btn btn-info btn-sm">Tải lên tệp</button></td>
                                        <td>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-menu-line"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{route('user.order.detail', ['code' => $order->code])}}" class="dropdown-item">Xem</a>
                                                <a href="javascript:;" class="dropdown-item" id="cancelOrder" data-id="{{$order->code}}">Hủy</a>
                                            </div>
                                            </div>                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>   
                              </div>                           
                          </div>
                          <div role="tabpanel" class="tab-pane" id="processing_order">
                            <div class="table-responsive">
                                <table class="table table-bordered datatable" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Khuyến mãi</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($processing_orders as $order)
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
                                    <tr>
                                        <th scope="row" style="font-size: 12px;">{{$order->id}}</th>
                                        <td style="font-size: 12px;">
                                            @foreach($order->detail as $item)
                                                <p>{{$item->product->name}}</p>
                                            @endforeach                                                
                                        </td>
                                        <td>
                                            {{number_format($price)}}đ
                                        </td>
                                        <td>
                                            {{$quantity}}
                                        </td>
                                        <td>
                                            {{number_format($discount)}}đ
                                        </td>                                            
                                        <td>{{number_format($price + $discount)}}đ</td>
                                        <td><button type="buttom" class="btn btn-info btn-sm">Tải lên tệp</button></td>
                                        <td>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-menu-line"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{route('user.order.detail', ['code' => $order->code])}}" class="dropdown-item">Xem</a>
                                            </div>
                                            </div>                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>   
                              </div>  
                          </div>
                          <div role="tabpanel" class="tab-pane" id="completed_order">
                            <table class="table table-hover datatable" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Khuyến mãi</th>
                                    <th scope="col">Thành tiền</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($completed_orders as $order)
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
                                <tr>
                                    <th scope="row" style="font-size: 12px;">
                                        @if($order->status == 'completed')
                                            <span class="badge badge-success">Hoàn tất</span>
                                        @else
                                            <span class="badge badge-danger">Đã hủy</span>
                                        @endif
                                    </th>
                                    <td style="font-size: 12px;">
                                        @foreach($order->detail as $item)
                                            <p>{{$item->product->name}}</p>
                                        @endforeach                                                
                                    </td>
                                    <td>
                                        {{number_format($price)}}đ
                                    </td>
                                    <td>
                                        {{$quantity}}
                                    </td>
                                    <td>
                                        {{number_format($discount)}}đ
                                    </td>                                            
                                    <td>{{number_format($price + $discount)}}đ</td>
                                    <td><button type="buttom" class="btn btn-info btn-sm">Tải lên tệp</button></td>
                                    <td>
                                        <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-menu-line"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{route('user.order.detail', ['code' => $order->code])}}" class="dropdown-item">Xem</a>
                                        </div>
                                        </div>                                                
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>                                 
                          </div>
                        </div>
                      </div>
                </div>
            </div>
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