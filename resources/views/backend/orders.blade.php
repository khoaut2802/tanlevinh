<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('components.alert')
                    <div style='border-bottom: 2px solid #eaeaea'>
                        <ul class='flex cursor-pointer'>
                          <li class='py-2 px-6 rounded-t-lg @if(request()->routeIs('products')) bg-gray-100 @else bg-white @endif'><a href="{{route('products')}}">Danh sách đơn hàng</a></li>
                        </ul>
                    </div>
                    <div class="py-8">
                        <div class="my-2 flex sm:flex-row flex-col justify-between items-center">
                            <form method="POST" action="{{route('orders_search')}}" class="flex">
                                @csrf
                            <div class="flex flex-row mb-1 sm:mb-0">
                                <div class="relative">
                                    <select
                                        name="per_page"
                                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="orderFilterLimit">
                                        <option value="5" @if(request()->query('per_page') == 5)selected @endif>5</option>
                                        <option value="10" @if(request()->query('per_page') == 10)selected @endif>10</option>
                                        <option value="20" @if(request()->query('per_page') == 20)selected @endif>20</option>
                                        <option value="50" @if(request()->query('per_page') == 50)selected @endif>20</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <select
                                        name="status"
                                        class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500" id="orderFilterStatus">
                                        
                                        <option value="" @if(!request()->query('status'))selected @endif>Tất cả</option>
                                        <option value="pending" @if(request()->query('status') == 'pending')selected @endif>Đang chờ</option>
                                        <option value="canceled"@if(request()->query('status') == 'canceled')selected @endif>Đã hủy</option>
                                        <option value="processing"@if(request()->query('status') == 'processing')selected @endif>Đang xử lý</option>
                                        <option value="completed"@if(request()->query('status') == 'completed')selected @endif>Hoàn tất</option>
                                    </select>
                                </div>
                            </div>
                            <div class="block relative">
                                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                        <path
                                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                                        </path>
                                    </svg>
                                </span>
                                <input placeholder="Search" name="search" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                                <input type="submit" class="hidden" value="submit">
                            </div>
                            </form>
                        </div>
                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-auto">
                            <div class="inline-block min-w-full shadow rounded-lg">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                               Mã đơn hàng
                                            </th>                                          
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Sản phẩm
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Số lượng
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Số tiền
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Tạo lúc
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Trạng thái
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Tệp tin
                                            </th>                                           
                                            <th
                                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Hành động
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders['data'] as $order)
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
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        @if(strpos($order['code'], 'PATRON') !== false)
                                                            (Khách quen) <br>
                                                        @endif
                                                        <strong>{{$order['code']}}</strong><br>
                                                        {{$order['user']['name'] ?? ''}}<br>
                                                        {{$order['user']['email'] ?? ''}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">                                   
                                                    @if(strpos($order['code'], 'PATRON') !== false)
                                                        @foreach($order['detail'] as $detail)
                                                           {{json_decode($detail['product_attrs'])->name ?? ''}}
                                                        @endforeach                                                            
                                                    @else                                                    
                                                        @foreach($order['detail'] as $detail)
                                                                {{$detail['product']['name']}}</br>
                                                        @endforeach
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$quantity}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$price - $discount}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{formatDate($order['created_at'], 'd-m-Y H:i:s')}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                @if($order['status'] == 'completed')
                                                    <span class="block rounded text-white bg-green-700 py-2 px-2">Hoàn tất</span>
                                                @elseif($order['status'] == 'pending')
                                                    <span class="block rounded text-white bg-blue-700 py-2 px-2">Đang chờ xác nhận</span>
                                                @elseif($order['status'] == 'processing')
                                                    <span class="block rounded text-white bg-yellow-700 py-2 px-2">Đang xử lý</span>                        
                                                @else
                                                    <span class="block rounded text-white bg-red-700 py-2 px-2">Đã hủy</span>
                                                @endif
                                            </td>   
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                @if($order['file'] == null)
                                                    Chưa có
                                                @else
                                                    <a href="{{asset($order['file'])}}" class="text-blue-700" target="_blank">Tải về</a>
                                                @endif
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="group inline-block" x-data="{show: false}">
                                                    <button
                                                        type="button"
                                                      class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32"
                                                      x-on:click="show = !show"
                                                    >
                                                      <span class="pr-1 font-semibold flex-1">Menu</span>
                                                      <span class="fill-current transform
                                                      transition duration-150 ease-in-out">
                                                       <i class="ri-arrow-drop-down-line" style="font-size:24px"></i>
                                                      </span>
                                                    </button>
                                                    <ul
                                                      class="bg-white border rounded-sm relative 
                                                    ease-in-out min-w-32 z-10"
                                                    x-show="show"
                                                    >
                                                      <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer "><a href="{{route('orders_detail', ['id' => $order['code']])}}">Chi tiết</a></li>
                                                      <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer text-green-500 changeOrderStauts" data-action="completed" data-id="{{$order['code']}}">Duyệt</li>
                                                      <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer text-yellow-500 changeOrderStauts" data-action="processing" data-id="{{$order['code']}}">Xử lý</li>
                                                      <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer text-red-500 changeOrderStauts" data-action="canceled" data-id="{{$order['code']}}">Hủy</li>
                                                    </ul>
                                                  </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p>No product found.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div
                                    class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between ">
                                    <span class="text-xs xs:text-sm text-gray-900">
                                        Bạn đang ở trang {{$orders['current_page']}} / {{$orders['last_page']}} trên tổng số {{$orders['total']}} sản phẩm
                                    </span>
                                    <div class="inline-flex mt-2 xs:mt-0">
                                        <a  href="{{route('orders', ['page' => $orders['current_page'] - 1 <= 0 ? 1 : $orders['current_page'] - 1])}}"
                                            class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                            Trước
                                        </a>
                                        <a  href="{{route('orders', ['page' => $orders['current_page'] + 1 > $orders['last_page'] ? $orders['last_page'] : $orders['current_page'] + 1])}}"
                                            class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                                            Sau
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
