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
                        <div class="flex justify-center w-full my-2">
                            <img src="{{asset('assets/images/logo.png')}}" width="48">
                        </div>
                        <div class="flex justify-between w-full my-2">
                            <h6 class="text-muted">Số phiếu: <strong>{{\Carbon\Carbon::now()->format('dmYhis')}}</strong></h6>
                            <h6 class="text-muted">Mã đơn hàng: <strong>{{$order->code}}</strong></h6>
                        </div>
                        <h6 class="text-muted">Khách hàng: <b>{{$order->user->name}}</b></h6>
                        <p class="mb-2">
                            Điện thoại: <b>{{$order->user->phone}}</b> <br>
                            Email: <b>{{$order->user->email}}</b> <br>
                            Địa chỉ: <b>{{$order->user->address}}</b>
                        </p>                        
                        <div class="overflow-x-auto">                           
                            @foreach($order->detail as $item)
                                <table class="table-auto border-collapse border border-green-900 w-full mb-3">
                                    <tbody class="text-gray-700">                                    
                                    @if($item->product_id != 0)
                                    <tr class="text-center border border-green-900">
                                        <th>
                                            Tên sản phẩm:
                                        </th>
                                        <td>{{$item->product->name}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach(array_chunk(json_decode($item->product_attrs),2) as $attrs)
                                    <tr class="text-center border border-green-900">
                                        @foreach($attrs as $attr)
                                                <th>{{$attr->name}}:</th>
                                                <td>{{$attr->values->name}} ({{number_format($attr->values->price)}}đ)</td>
                                        @endforeach
                                        @if($loop->last)
                                            <th>Số lượng</th> <td>{{$item->quantity}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    <tr class="text-center border border-green-900"> <th>Giá</th> <td>{{number_format($price)}}đ</td> <td></td><td></td></tr>
                                    @else
                                        @if(strpos($order['code'], 'PATRON') !== false)
                                            @foreach(json_decode($item['product_attrs']) as $key => $value)
                                                <tr class="text-center border border-green-900">
                                                    <th>{{__($key)}}</th>
                                                    <td>{{$value}}</td>
                                                </tr>
                                            @endforeach                                                       
                                        @endif
                                    @endif
                                    </tbody>
                                </table>                                    
                            @endforeach
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
