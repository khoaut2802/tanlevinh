<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đơn hàng #'.$order->code) }}
            {!! formatStatus($order->status) !!}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
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
                    <div class="flex justify-between items-center">
                        @if(auth()->user()->user_type === 'admin')
                        <div class="flex flex-row">
                            <button type="button" data-action="completed" data-id="{{$order['code']}}" class="changeOrderStauts bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                                Duyệt
                            </button>

                            <button type="button" data-action="processing" data-id="{{$order['code']}}" class="changeOrderStauts bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                                Xử lý
                            </button>

                            <button type="button" data-action="canceled" data-id="{{$order['code']}}" class="changeOrderStauts bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                                Hủy
                            </button>
                        </div>

                        <div class="flex flex-row">
                            <button type="button" class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 modal" data-target="#select_machine_modal">
                                Chọn máy sản xuất
                            </button>

                            <a href="{{route('order_print', ['code' => $order->code])}}" class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 print">
                                In
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="py-8" id="print-area">
                        <div class="flex justify-between w-full my-2">
                            <h6 class="text-muted">Số phiếu: <strong>{{\Carbon\Carbon::now()->format('dmYhis')}}</strong></h6>
                            <h6 class="text-muted">Mã đơn hàng: <strong>{{$order->code}}</strong></h6>
                        </div>
                        <h6 class="text-muted">Khách hàng: <b>{{$order->user->name}}</b></h6>
                        {{-- <p class="mb-2">
                            Điện thoại: <b>{{$order->user->phone}}</b> <br>
                            Email: <b>{{$order->user->email}}</b> <br>
                            Địa chỉ: <b>{{$order->user->address}}</b>
                        </p>                         --}}
                        <div class="overflow-x-auto">
                            @foreach($order->detail as $key => $item)
                                {{-- <p class="text-lg font-bold">STT: {{$key + 1}}</p> --}}
                                <table class="table-auto border-collapse border border-green-900 w-full mb-3">
                                    <tbody class="text-gray-700">
                                    @if($item->product_id != 0)
                                    <tr class="text-left border border-green-900">
                                        <th>
                                            Tên sản phẩm:
                                        </th>
                                        <td class="border-r-2 border-black">{{$item->product->name}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach(array_chunk(json_decode($item->product_attrs),2) as $attrs)
                                    <tr class="text-left border border-green-900">
                                        @foreach($attrs as $key => $attr)
                                                <th>{{$attr->name}}:</th>
                                                <td @if($key % 2 == 0)class="border-r-2 border-black"@endif>{{$attr->values->name}} ({{is_numeric($attr->values->price) ? number_format($attr->values->price).'đ' : $attr->values->price}})</td>
                                        @endforeach
                                        @if($loop->last)
                                            <tr><th>Số lượng</th> <td>{{$item->quantity}}</td></tr>
                                            <tr class="text-left border border-green-900">
                                                <th>Cắt</th> <td class="border-r-2 border-black">{{$item->cut}}</td>
                                                <th>Bù hao</th> <td>{{$item->compensate}}</td>
                                            </tr>
                                        @endif
                                    </tr>
                                    @endforeach
                                    <tr class="text-left border border-green-900">
                                        @if(auth()->user()->user_type == 'admin')
                                            <th>Giá</th> <td class="border-r-2 border-black">{{is_numeric($price) ? number_format($price) : $price}}đ</td>
                                        @endif
                                        <th>Số lượng in</th> <td>{{$item->print_quantity}}</td>
                                    </tr>
                                    @else
                                        @if(strpos($order['code'], 'IMP') !== false || strpos($order['code'], 'PATRON') !== false)
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach(json_decode($item['product_attrs']) as $key => $value)
                                                <tr class="text-left border border-green-900">
                                                    <th class="border-r-2 border-black">{{__($key)}}</th>
                                                    <td class="px-2">{{$value}}</td>
                                                </tr>
                                                @php $i++; @endphp
                                            @endforeach
                                            <tr class="text-left border border-green-900">
                                                <th class="border-r-2 border-black">Số lượng</th>
                                                <td class="px-2">{{$item->quantity}}</td>
                                            </tr>
                                            <tr class="text-left border border-green-900">
                                                <th class="border-r-2 border-black">Cắt</th>
                                                <td class="px-2">{{$item->cut}}</td>
                                            </tr>
                                            <tr class="text-left border border-green-900">
                                                <th class="border-r-2 border-black">Bù hao</th>
                                                <td class="px-2">{{$item->compensate}}</td>
                                            </tr>
                                            <tr class="text-left border border-green-900">
                                                <th class="border-r-2 border-black">Số lượng in</th>
                                                <td class="px-2">{{$item->print_quantity}}</td>
                                            </tr>
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
    @if(auth()->user()->user_type === 'admin')
    <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="select_machine_modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form method="post" action="{{route('order.update_machine', ['id' => $order->id])}}">
                @csrf
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
