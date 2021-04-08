<x-user-layout>
    <div class="my-2 row">
        <div class="col-12 col-sm-2">
            @include('user.navbar')
        </div>
        <div class="col-12 col-sm-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Đơn hàng khách quen</span>
                    <a href="{{asset('/page/Hinh_thuc_thanh_toan')}}" class="btn btn-sm btn-primary">Hướng dẫn thanh toán</a>
                </div>
                <div class="card-body">
                    <div class="group-tabs">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item"><a class="nav-link active" href="#patron_orders" aria-controls="patron_orders" role="tab" data-toggle="tab">Danh sách đơn hàng</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                          <div role="tabpanel" class="tab-pane active" id="patron_orders">
                              <div class="table-responsive">
                                <table class="table table-striped datatable" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nội dung</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <th scope="row" style="font-size: 12px;">{{$order->code}}</th>
                                        <td>
                                            @foreach($order->detail as $item)
                                                @foreach(json_decode($item->product_attrs) as $key => $value)
                                                    {{__($key)}}: {{$value}}<br>
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($order->status == 'completed')
                                            <span class="badge badge-success">Hoàn tất</span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge badge-info">Đang chờ xác nhận</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge badge-danger">Đã hủy</span>
                                            @else
                                                <span class="badge badge-warning">Đang xử lý</span>
                                            @endif
                                        </td>
                                        <td>@if($order->file != null)<span class="badge badge-success">Đã tải lên</span>@else <button type="buttom" class="btn btn-info btn-sm uploadFile" data-id="{{$order->code}}">Tải lên tệp</button>@endif</td>
                                        <td>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-menu-line"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="javascript:;" class="dropdown-item cancelOrder" data-id="{{$order->code}}">Hủy</a>
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
    </div>



    <div id="uploadFileModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Đơn hàng số #<span id="uploadFileHeader"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" id="uploadFileForm">
        <div class="modal-body">
            <input type="hidden" name="order_id">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" name="orderFile" aria-describedby="inputGroupFileAddon01" required>
                  <label class="custom-file-label" for="inputGroupFile01">Chọn tệp tin</label>
                </div>
              </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Tải lên</button>
        </div>
        </form>
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

            $('.cancelOrder').on('click', function() {
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

            $('.custom-file-input').on('change', function() {
                var file = $('#inputGroupFile01')[0].files[0].name;

                $('label[for="inputGroupFile01"]').text(file)
            })

            $('.uploadFile').on('click', function() {
                var id = $(this).attr('data-id');
                $('#uploadFileHeader').text(id);
                $('input[name="order_id"]').val(id);
                $('#uploadFileModal').modal('show');
            })

            $('#uploadFileForm').on('submit', function(e) {
                e.preventDefault();

                var id = $('input[name="order_id"]').val();
                var form = $('#uploadFileForm')[0];
                var data = new FormData(form);

                $.ajax({
                    url: '{{route('user.order.upload')}}',
                    data: data,
                    type: 'POST',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(msg) {
                        swal({
                            title: "Congratulations!",
                            text: "Bạn đã tải lên tệp thành công.",
                            type: "success",
                            timer: 3000,
                            showCancelButton: false,
                            showCloseButton: false,
                            showConfirmButton: false,
                            showLoaderOnConfirm: true,
                            onClose() {
                                window.location.reload();
                            }
                        })
                    }
                });
            })
        </script>
    </x-slot>
</x-user-layout>
