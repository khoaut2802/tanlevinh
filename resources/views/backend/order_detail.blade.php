<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đơn hàng #'.$order->code) }}
            @if($order['status'] == 'completed')
                <span class="rounded text-white bg-green-700 py-2 px-2">Hoàn tất</span>
            @elseif($order['status'] == 'pending')
                <span class="rounded text-white bg-blue-700 py-2 px-2">Đang chờ xác nhận</span>
            @elseif($order['status'] == 'processing')
                <span class="rounded text-white bg-yellow-700 py-2 px-2">Đang xử lý</span>                        
            @else
                <span class="rounded text-white bg-red-700 py-2 px-2">Đã hủy</span>
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
                        <button type="button" data-action="completed" data-id="{{$order['code']}}" class="changeOrderStauts bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 modal" data-target="#add_product_modal">
                            Duyệt
                        </button>

                        <button type="button" data-action="processing" data-id="{{$order['code']}}" class="changeOrderStauts bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 modal" data-target="#add_product_modal">
                            Xử lý
                        </button>

                        <button type="button" data-action="canceled" data-id="{{$order['code']}}" class="changeOrderStauts bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 modal" data-target="#add_product_modal">
                            Hủy
                        </button>
                    </div>
                    <div class="py-8">
                        <h6 class="text-muted">Giao tới</h6>
                        <p class="mb-2"><b>{{$order->user->name}}</b> <br>
                            Điện thoại: <b>{{$order->user->phone}}</b> <br>
                            Email: <b>{{$order->user->email}}</b> <br>
                            Địa chỉ: <b>{{$order->user->address}}</b>
                        </p>                        
                        <div class="overflow-x-auto">
                        <table class="table-auto border-collapse w-full">
                            <thead>
                              <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">#</th>
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Hình ảnh</th>
                                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Sản phẩm</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Số lượng</th>
                                <th class="px-4 py-2 " style="background-color:#f8f8f8">Giá</th>
                              </tr>
                            </thead>
                            <tbody class="text-sm font-normal text-gray-700">
                                @foreach($order->detail as $item)
                                <tr>
                                    <td width="150">
                                        {{$order->code}}
                                    </td>
                                    <td width="150">
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
</x-app-layout>