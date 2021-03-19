<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    @php
        $statistic = statistics();
    @endphp

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center ">
                <div class="p-4 w-full">
                  <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-6 md:col-span-3">
                      <div class="flex flex-row bg-white shadow-sm rounded p-4">
                        <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-blue-100 text-blue-500">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="flex flex-col flex-grow ml-4">
                          <div class="text-sm text-gray-500">Người dùng</div>
                          <div class="font-bold text-lg">{{$statistic->total_user}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 md:col-span-3">
                      <div class="flex flex-row bg-white shadow-sm rounded p-4">
                        <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-green-100 text-green-500">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="flex flex-col flex-grow ml-4">
                          <div class="text-sm text-gray-500">Đơn hàng</div>
                          <div class="font-bold text-lg">{{$statistic->total_order}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 md:col-span-3">
                      <div class="flex flex-row bg-white shadow-sm rounded p-4">
                        <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-orange-100 text-orange-500">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div class="flex flex-col flex-grow ml-4">
                          <div class="text-sm text-gray-500">Sản phẩm</div>
                          <div class="font-bold text-lg">{{$statistic->total_product}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 md:col-span-3">
                      <div class="flex flex-row bg-white shadow-sm rounded p-4">
                        <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-red-100 text-red-500">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex flex-col flex-grow ml-4">
                          <div class="text-sm text-gray-500">Doanh thu trong tháng</div>
                          <div class="font-bold text-lg">{{number_format($statistic->total_revenue)}}đ</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>       
              @php
                $carbon = new \Carbon\Carbon;
                $start = $carbon->now()->firstOfMonth();
                $end = $carbon->now()->lastOfMonth();
            @endphp     
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <label for="daterange">Xem doanh thu theo mốc thời gian:</label>
                    <input type="text" name="daterange" value="{{request()->get('from', $start->format('m/d/Y'))}} - {{request()->get('to', $end->format('m/d/Y'))}}" class="rounded mb-3" />
                    <div class="float-right">
                        <h3>Doanh thu: {{number_format(statistics(request()->get('from', $start), request()->get('to', $end))->total_revenue)}}đ</h3>
                    </div>
                    <table class="border-collapse w-full">
                        <thead>
                            <tr>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Mã đơn hàng</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Ngày tạo</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Trạng thái</th>
                                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders['data'] as $order)
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Mã đơn hàng</span>
                                    #{{$order['code']}}
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Ngày tạo</span>
                                    {{formatDate($order['created_at'], 'd-m-Y')}}
                                </td>
                                  <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Trạng thái</span>
                                    @if($order['status'] == 'completed')
                                    <span class="rounded text-white bg-green-700 py-2 px-2">Hoàn tất</span>
                                    @elseif($order['status'] == 'pending')
                                        <span class="rounded text-white bg-blue-700 py-2 px-2">Đang chờ xác nhận</span>
                                    @elseif($order['status'] == 'processing')
                                        <span class="rounded text-white bg-yellow-700 py-2 px-2">Đang xử lý</span>                        
                                    @else
                                        <span class="rounded text-white bg-red-700 py-2 px-2">Đã hủy</span>
                                    @endif                                        
                                  </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Hành động</span>
                                    <a href="{{route('orders_detail', ['id' => $order['code']])}}" class="text-blue-400 hover:text-blue-600 underline">Chi tiết</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>                   
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
              opens: 'left'
            }, function(start, end, label) {
              window.location.href = '{{route("dashboard")}}?from=' + start.format('MM/DD/YYYY') + '&to=' + end.format('MM/DD/YYYY');
            });
          });
        </script>
    </x-slot>
</x-app-layout>
