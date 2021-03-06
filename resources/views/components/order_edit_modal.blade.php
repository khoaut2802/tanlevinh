@php
    if($action == 'edit') {
        // dd($order->detail);
        $detail = json_decode($order->detail[0]->product_attrs);
        $order_detail = $order->detail[0];
    }
@endphp
<div class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <form method="post" action="{{$form_url}}">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    @if($action == 'edit') Chỉnh sửa đơn hàng @else Tạo đơn hàng @endif
                </h3>
                <div class="mt-2">
                    @if($action == 'edit')

                        @if($order_detail->product_id == 0)
                            <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                <input type="text" name="name" value="{{$action == 'edit' ? $detail->name : ''}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên sản phẩm" required>
                            </div>
                            <label class="block">
                                <span class="text-gray-700">Khách hàng:</span>
                                <select name="user_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\User::customer()->get() as $user)
                                        <option value="{{$user->id}}" @if($action == 'edit' && $user->id == $order->user_id)selected @endif>{{$user->name}} ({{$user->email}})</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Loại giấy:</span>
                                <select name="paper_type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach($paper_types as $type)
                                        <option value="{{$type->name}}" @if($action == 'edit' && $type->name == $detail->paper_type)selected @endif>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block mt-2">
                                <span class="text-gray-700">Khổ giấy:</span>
                                <select name="paper_size" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach($paper_sizes as $size)
                                        <option value="{{$size->name}}" @if($action == 'edit' &&  $size->name == $detail->paper_size)selected @endif>{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <div class="flex justify-between items-center my-2">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Khổ in:</span>
                                    <input type="text" name="print_size" min="0" value="{{$action == 'edit' ? $detail->print_size : ''}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="VD: 54x79cm" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số kẽm:</span>
                                    <input type="number" name="zinc_quantity" min="1" value="{{$action == 'edit' ? $detail->zinc_quantity : ''}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Màu sắc:</span>
                                    <input type="text" name="color"  value="{{$action == 'edit' ? $detail->color : ''}}"class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số lượng:</span>
                                    <input type="number" name="quantity" min="1" value="{{$action == 'edit' ? $order_detail->quantity : ''}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Bù hao:</span>
                                    <input type="number" name="compensate" min="1" value="{{$action == 'edit' ? $order_detail->compensate : ''}}"class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Cắt:</span>
                                    <input type="number" name="cut" min="1" value="{{$action == 'edit' ? $order_detail->cut : ''}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số tiền:</span>
                                    <input type="number" name="price" min="0" value="{{$order_detail->price}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số lượng:</span>
                                    <input type="number" name="quantity" min="1" value="{{$order_detail->quantity}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                            </div>

                            <label class="block px-2 my-2">
                                <span class="text-gray-700">Máy sản xuất:</span>
                                <select name="print_machine" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\Machines::get() as $machine)
                                        <option value="{{$machine->name}}" @if($order->print_machine == $machine->name)selected @endif>{{$machine->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Trạng thái:</span>
                                <select name="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="pending" @if($order->status == 'pending')selected @endif>Chờ xác nhận</option>
                                    <option value="staff_received" @if($order->status == 'staff_received')selected @endif>Nhân viên nhận đơn</option>
                                    <option value="processing" @if($order->status == 'processing')selected @endif>Đang xử lý</option>
                                    <option value="waiting" @if($order->status == 'waiting')selected @endif>Chờ giấy kẽm</option>
                                    <option value="completed" @if($order->status == 'completed')selected @endif>Hoàn tất</option>
                                    <option value="canceled" @if($order->status == 'canceled')selected @endif>Hủy bỏ</option>
                                </select>
                            </div>

                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Ghi chú:</span>
                                <textarea name="note" value="{{$order->note}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                        @else
                            <label class="block">
                                <span class="text-gray-700">Khách hàng:</span>
                                <select name="user_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\User::customer()->get() as $user)
                                        <option value="{{$user->id}}" @if($action == 'edit' && $user->id == $order->user_id)selected @endif>{{$user->name}} ({{$user->email}})</option>
                                    @endforeach
                                </select>
                            </label>
                            @php
                                $order_product_group = \App\Models\Products::where('id', $order_detail->product_id)->first()->group_id ?? 0;
                            @endphp
                            <label class="block my-2">
                                <span class="text-gray-700">Nhóm sản phẩm:</span>
                                <select name="product_group" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\ProductGroups::get() as $group)
                                        <option value="{{$group->id}}" @if($action == 'edit' && $order_product_group == $group->id)selected @elseif($loop->first)selected @endif>
                                            {{$group->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block my-2">
                                <span class="text-gray-700">Sản phẩm:</span>
                                <select id="product_list" name="product" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\Products::get() as $product)
                                        <option value="{{$product->id}}" @if($action == 'edit' && $order->product_id == $product->id)selected @elseif($loop->first)selected @endif>
                                            {{$product->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <div id="product_attrs_content" class="grid grid-flow-col grid-cols-3 grid-rows-3 gap-4">
                            @foreach($detail as $attr)
                                <div class="flex items-center">
                                    <div>
                                        <label class="block my-2">
                                            <span class="text-gray-700">{{$attr->name}}:</span>
                                            <select name="attr_{{$attr->id}}" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                @foreach(json_decode(\App\Models\Attributes::where('id', $attr->id)->first()->options) as $key => $option)
                                                    <option value="{{$key}}" data-price="{{$option->price ?? 0}}">{{$option->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số tiền:</span>
                                    <input type="number" name="price" min="0" value="{{$order_detail->price}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số lượng:</span>
                                    <input type="number" name="quantity" min="1" value="{{$order_detail->quantity}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Bù Hao:</span>
                                    <input type="number" name="compensate" min="0" value="{{$order_detail->compensate}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Cắt:</span>
                                    <input type="number" name="cut" min="1" value="{{$order_detail->cut}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                </div>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                    <span class="text-gray-700">Số lượng in:</span>
                                    <input type="number" name="print_quantity" min="1" value="{{$order_detail->print_quantity}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                                </div>
                            </div>
                            <label class="block px-2 my-2">
                                <span class="text-gray-700">Máy sản xuất:</span>
                                <select name="print_machine" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\Machines::get() as $machine)
                                        <option value="{{$machine->name}}" @if($order->print_machine == $machine->name)selected @endif>{{$machine->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Trạng thái:</span>
                                <select name="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="pending" @if($order->status == 'pending')selected @endif>Chờ xác nhận</option>
                                    <option value="staff_received" @if($order->status == 'staff_received')selected @endif>Nhân viên nhận đơn</option>
                                    <option value="processing" @if($order->status == 'processing')selected @endif>Đang xử lý</option>
                                    <option value="waiting" @if($order->status == 'waiting')selected @endif>Chờ giấy kẽm</option>
                                    <option value="completed" @if($order->status == 'completed')selected @endif>Hoàn tất</option>
                                    <option value="canceled" @if($order->status == 'canceled')selected @endif>Hủy bỏ</option>
                                </select>
                            </div>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Ghi chú:</span>
                                <textarea name="note" value="{{$order->note}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                        @endif
                    @else
                        <label class="block">
                            <span class="text-gray-700">Khách hàng:</span>
                            <select name="user_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach(\App\Models\User::customer()->get() as $user)
                                    <option value="{{$user->id}}" @if($action == 'edit' && $user->id == $order->user_id)selected @endif>{{$user->name}} ({{$user->email}})</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block my-2">
                            <span class="text-gray-700">Nhóm sản phẩm:</span>
                            <select name="product_group" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach(\App\Models\ProductGroups::get() as $group)
                                    <option value="{{$group->id}}" @if($loop->first)selected @endif>
                                        {{$group->name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block my-2">
                            <span class="text-gray-700">Sản phẩm:</span>
                            <select id="product_list" name="product" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach(\App\Models\Products::get() as $product)
                                    <option value="{{$product->id}}" @if($loop->first)selected @endif>
                                        {{$product->name}}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <div id="product_attrs_content" class="grid grid-flow-col grid-cols-3 grid-rows-3 gap-4">
                        @foreach(\App\Models\Products::get()[0]->attributes as $attr)
                            <div class="flex items-center">
                                <div>
                                    <label class="block my-2">
                                        <span class="text-gray-700">{{$attr->attr->name}}:</span>
                                        <select name="attr_{{$attr->attr_id}}" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            @foreach(json_decode($attr->values) as $key => $value)
                                                @php
                                                    $attrDetail = getAttrValue($attr->attr_id, $value);
                                                    // if($key == 0)
                                                    //     $attrPrice = $attrPrice + $attrDetail->price ?? 0;
                                                @endphp
                                                <option value="{{$value}}" data-price="{{$attrDetail->price ?? 0}}">{{$attrDetail->name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Số tiền:</span>
                                <input type="number" name="price" min="0" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Số lượng:</span>
                                <input type="number" name="quantity" min="1" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Bù Hao:</span>
                                <input type="number" name="compensate" min="0" value="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Cắt:</span>
                                <input type="number" name="cut" min="1" value="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                                <span class="text-gray-700">Số lượng in:</span>
                                <input type="number" name="print_quantity" min="1" value="15" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                            </div>
                        </div>
                        <label class="block px-2 my-2">
                            <span class="text-gray-700">Máy sản xuất:</span>
                            <select name="print_machine" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach(\App\Models\Machines::get() as $machine)
                                    <option value="{{$machine->name}}">{{$machine->name}}</option>
                                @endforeach
                            </select>
                        </label>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                            <span class="text-gray-700">Trạng thái:</span>
                            <select name="status" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="pending" selected>Chờ xác nhận</option>
                                <option value="staff_received">Nhân viên nhận đơn</option>
                                <option value="processing">Đang xử lý</option>
                                <option value="waiting">Chờ giấy kẽm</option>
                                <option value="completed">Hoàn tất</option>
                                <option value="canceled">Hủy bỏ</option>
                            </select>
                        </div>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3 px-2">
                            <span class="text-gray-700">Ghi chú:</span>
                            <textarea name="note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>
                    @endif
                </div>
            </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Lưu thay đổi
          </button>
          <button type="button"
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('order_modal').innerHTML = ''">
            Hủy bỏ
          </button>
        </div>
        </form>
      </div>
      </div>
    </div>
