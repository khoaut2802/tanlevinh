<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đơn hàng #'.$order->code) }}
            @if($order['status'] == 'completed')
                <span class="block rounded text-white bg-green-700 py-2 px-2">Hoàn tất</span>
            @elseif($order['status'] == 'pending')
                <span class="block rounded text-white bg-blue-700 py-2 px-2">Đang chờ xác nhận</span>
            @elseif($order['status'] == 'processing')
                <span class="block rounded text-white bg-yellow-700 py-2 px-2">Đang xử lý</span>                        
            @else
                <span class="block rounded text-white bg-red-700 py-2 px-2">Đã hủy</span>
            @endif            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('components.alert')
                    @php
                        $price = 0;
                        $quantity = 0;
                        $discount = 0;
                
                        foreach($order['detail'] as $item) {
                            $price = $price + $item['price'] * $item['quantity'];
                            $quantity = $quantity + $item['quantity'];
                            $discount = $discount + $item['discount'];
                        }
                    @endphp  
                    <div>
                        <button type="button" data-action="completed" data-id="{{$order['code']}}" class="changeOrderStauts bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                            Duyệt
                        </button>

                        <button type="button" data-action="processing" data-id="{{$order['code']}}" class="changeOrderStauts bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                            Xử lý
                        </button>

                        <button type="button" data-action="canceled" data-id="{{$order['code']}}" class="changeOrderStauts bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                            Hủy
                        </button>
                        <div class="float-right">
                            <button onclick="PrintElem('print-area');" type="button" class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 print">
                                In
                            </button>                        
                        </div>
                    </div>
                    <div class="py-8" id="print-area">
                        <div class="flex text-center my-2">
                            <img src="{{asset('assets/images/logo.png')}}" width="48">
                        </div>
                        <h6 class="text-muted">Số phiếu: <strong>{{\Carbon\Carbon::now()->format('dmYhis')}}</strong></h6>
                        <h6 class="text-muted">Giao tới</h6>
                        <p class="mb-2"><b>{{$order->user->name}}</b> <br>
                            Điện thoại: <b>{{$order->user->phone}}</b> <br>
                            Email: <b>{{$order->user->email}}</b> <br>
                            Địa chỉ: <b>{{$order->user->address}}</b>
                        </p>                        
                        <div class="overflow-x-auto">
                        <table class="table-auto border-collapse w-full divide-y divide-gray-200">
                            <thead>
                              <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">#</th>
                                @if($item->product_id != 0)
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Hình ảnh</th>
                                @endif
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Sản phẩm</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Số lượng</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Giá</th>
                              </tr>
                            </thead>
                            <tbody class="text-sm font-normal text-gray-700 divide-y divide-gray-500">
                                @foreach($order->detail as $item)
                                <tr>
                                    <td width="150">
                                        {{$order->code}}
                                    </td>
                                    @if($item->product_id != 0)
                                        <td width="150">
                                            <img src="{{asset($item->product->image)}}" class="border" width="64px">
                                        </td>
                                    @endif
                                    <td>
                                        @php
                                            $attrs = json_decode($item->product_attrs);
                                        @endphp

                                        @if($item->product_id != 0)
                                        <p class="title mb-0">{{$item->product->name}}</p>
                                            @foreach(json_decode($item->product_attrs) as $attr)
                                            <p class="title mb-0">Tên: {{$attr->name}}</p>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th>Loại giấy:</th>
                                                        <td>{{$attr->paper_type}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Khổ giấy:</th>
                                                        <td>{{$attr->paper_size}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Khổ in:</th>
                                                        <td>{{$attr->print_size}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Số kẽm:</th>
                                                        <td>{{$attr->zinc_quantity}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Màu sắc:</th>
                                                        <td>{{$attr->quantity}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Số lượng:</th>
                                                        <td>{{$attr->zinc_quantity}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bù hao:</th>
                                                        <td>{{$attr->compensate}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cắt:</th>
                                                        <td>{{$attr->cut}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endforeach
                                        @else
                                        @if(strpos($order['code'], 'PATRON') !== false)
                                            @foreach(json_decode($item['product_attrs']) as $key => $value)
                                                {{__($key)}}: {{$value}}<br>
                                            @endforeach                                                       
                                        @endif
                                    </td>
                                    <td> SL: {{$item->quantity}} </td>
                                    <td>{{number_format($price)}}đ</td>
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

    <x-slot name="script">
        <script>
            function PrintElem(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    </x-slot>
</x-app-layout>
