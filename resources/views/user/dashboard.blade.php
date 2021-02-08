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
                                    <table class="table" id="datatable">
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
                                        <tr>
                                            <th scope="row">{{$order->id}}</th>
                                            <td>{{$order->id}}}</td>
                                            <td>{{$order->id}}}</td>
                                            <td>{{$order->id}}}</td>
                                            <td>{{$order->id}}}</td>
                                            <td>{{$order->id}}}</td>
                                            <td>{{$order->id}}}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm">Sửa</button>
                                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>   
                              </div>                           
                          </div>
                          <div role="tabpanel" class="tab-pane" id="processing_order">This is Profile content</div>
                          <div role="tabpanel" class="tab-pane" id="completed_order">This is Messages content</div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>