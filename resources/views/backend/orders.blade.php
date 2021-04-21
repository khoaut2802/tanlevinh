<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form method="GET" action="{{route('orders')}}" class="w-100">
                @csrf
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input placeholder="Nhập mã đơn hàng, email người đặt hoặc tên người đặt để tìm kiếm" name="search" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                    <input type="submit" class="hidden" value="submit">
                </div>
            </form>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('components.alert')
                    <div class="flex justify-between items-center">
                        <a href="{{route('orders')}}">Danh sách đơn hàng</a>
                        @if(auth()->user()->user_type === 'admin')
                            <button type="button" class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1" id="showCreateOrderModal">
                                Tạo đơn hàng
                            </button>
                        @endif
                    </div>
                    <div class="py-8">
                        <div class="my-2 flex sm:flex-row flex-col justify-between items-center">
                            <form method="GET" action="{{route('orders')}}" class="flex">
                                @csrf
                            <div class="flex flex-row mb-1 sm:mb-0">
                                <div class="relative">
                                    <select
                                        name="per_page"
                                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="orderFilterLimit">
                                        <option value="5" @if(request()->query('per_page') == 5)selected @endif>5</option>
                                        <option value="10" @if(request()->query('per_page') == 10)selected @endif>10</option>
                                        <option value="20" @if(request()->query('per_page') == 20)selected @endif>20</option>
                                        <option value="50" @if(request()->query('per_page') == 50)selected @endif>50</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <select
                                        name="status"
                                        class="appearance-none h-full rounded-r border-t border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500" id="orderFilterStatus">

                                        <option value="" @if(!request()->query('status'))selected @endif>Tất cả</option>
                                        <option value="pending" @if(request()->query('status') == 'pending')selected @endif>Đang chờ</option>
                                        <option value="canceled"@if(request()->query('status') == 'canceled')selected @endif>Đã hủy</option>
                                        <option value="processing"@if(request()->query('status') == 'processing')selected @endif>Đang xử lý</option>
                                        <option value="completed"@if(request()->query('status') == 'completed')selected @endif>Hoàn tất</option>
                                    </select>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div id="doublescroll" class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-auto">
                            <div class="inline-block min-w-full shadow rounded-lg">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            STT
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                               Mã đơn hàng
                                            </th>
                                            <th
                                            class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Người đặt
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Sản phẩm
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Máy sản xuất
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Số lượng
                                            </th>
                                            @if(auth()->user()->user_type === 'admin')
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Số tiền
                                            </th>
                                            @endif
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tạo lúc
                                            </th>
                                            <th
                                                class="max-w-md px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Ghi chú
                                            </th>
                                            <th
                                                class="max-w-md px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Đảm nhận
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Trạng thái
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tệp tin
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Hành động
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
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
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$i}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        @if(strpos($order['code'], 'IMP') !== false || strpos($order['code'], 'PATRON') !== false)
                                                            (Khách quen) <br>
                                                        @endif
                                                        <strong>{{$order['code']}}</strong><br>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$order['user']['name'] ?? ''}}<br>
                                                    {{$order['user']['email'] ?? ''}}
                                                </p>
                                            </td>

                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    @if(strpos($order['code'], 'IMP') !== false || strpos($order['code'], 'PATRON') !== false)
                                                        @foreach($order['detail'] as $detail)
                                                           {{json_decode($detail['product_attrs'])->name ?? ''}}
                                                        @endforeach
                                                    @else
                                                        @foreach($order['detail'] as $detail)
                                                        {{-- {{dd($detail)}} --}}
                                                                {{$detail['product']['name']}}</br>
                                                        @endforeach
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$order['print_machine'] ?? 'Không có'}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$quantity}}
                                                </p>
                                            </td>
                                            @if(auth()->user()->user_type === 'admin')
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$price - $discount}}
                                                </p>
                                            </td>
                                            @endif
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{formatDate($order['created_at'], 'd-m-Y H:i:s')}}
                                                </p>
                                            </td>
                                            <td class="max-w-md px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$order['note']}}
                                                </p>
                                            </td>
                                            <td class="max-w-md px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$order['staff'] ? $order['staff']['email'] : ''}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                {!! formatStatus($order['status']) !!}
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                @if($order['file'] == null)
                                                    Chưa có
                                                @else
                                                    <a href="{{asset($order['file'])}}" class="text-blue-700" target="_blank">Tải về</a>
                                                @endif
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
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
                                                      @if(auth()->user()->user_type === 'staff')
                                                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100"><a class="block updateMachineModal modal" href="javascript:;" data-code="{{$order['id']}}" data-target="#staff_update_modal">Đổi trạng thái</a></li>
                                                      @endif
                                                      <li class="rounded-sm px-3 py-1 hover:bg-gray-100"><a class="block" href="{{route('orders_detail', ['id' => $order['code']])}}">Chi tiết</a></li>
                                                      @if(auth()->user()->user_type === 'admin')
                                                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100"><a class="block updateMachineModal modal" href="javascript:;" data-code="{{$order['id']}}" data-target="#select_machine_modal">Máy sản xuất</a></li>
                                                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100"><a class="block editOrder" href="javascript:;" data-code="{{$order['code']}}">Chỉnh sửa</a></li>
                                                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer "><a class="block" href="{{route('order_print', ['code' => $order['code']])}}">In</a></li>
                                                        <li class="rounded-sm px-3 py-1 hover:bg-gray-100 cursor-pointer text-red-500 changeOrderStauts" data-action="canceled" data-id="{{$order['code']}}">Hủy</li>
                                                      @endif
                                                    </ul>
                                                  </div>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @empty
                                        <tr>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                            <p>Không tìm thấy kết quả.</p>
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
    @if(auth()->user()->user_type === 'admin')
      <div id="order_modal"></div>
      <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="select_machine_modal">
          <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
              <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
              <form method="post" action="{{route('order.update_machine')}}">
                  @csrf
                  <input type="hidden" name="id">
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                      Chọn Máy sản xuất
                    </h3>
                    <div class="mt-2">
                      <div class="relative flex w-full flex-wrap items-stretch mb-3">
                          <select name="print_machine" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                              @foreach(\App\Models\Machines::get() as $machine)
                                  <option value="{{$machine->name}}">{{$machine->name}}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                  Lưu
                </button>
                <button type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#select_machine_modal">
                  Cancel
                </button>
              </div>
              </form>
            </div>
          </div>
        </div>
    @endif
    <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="staff_update_modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form method="post" action="{{route('order.staff.update')}}">
                @csrf
                <input type="hidden" name="id">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                        Thay đổi trạng thái đơn hàng
                    </h3>
                    <div class="mt-2">
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="staff_received">Nhân viên nhận đơn</option>
                                <option value="waiting">Chờ giấy kẽm</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="completed">Hoàn tất</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Lưu
                </button>
                <button type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#staff_update_modal">
                    Cancel
                </button>
                </div>
            </form>
          </div>
        </div>
      </div>
</x-app-layout>

