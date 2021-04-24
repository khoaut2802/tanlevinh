@php
$total = 0;
$order_detail = '';
$attrs = '';
@endphp
<table>
    <thead>
    <tr>
        <th><b>STT</b></th>
        <th><b>Mã đơn hàng</b></th>
        <th><b>Người đặt</b></th>
        <th><b>Sản phẩm</b></th>
        <th><b>Máy sản xuất</b></th>
        <th><b>Số lượng</b></th>
        <th><b>Số tiền</b></th>
        <th><b>Ngày đặt</b></th>
        <th><b>Ghi chú</b></th>
        <th><b>Đảm nhận</b></th>
        <th><b>Trạng thái</b></th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
    @endphp
    @foreach($orders as $order)
    @foreach($order->detail as $detail)
        @php
            $order_detail = $detail;
            $attrs = json_decode($detail->product_attrs, true);
            $ar = [];

            if($detail->product_id != 0) {
                foreach($attrs as $attr) {
                    $ar[$attr['name']] = $attr['values']['name'];
                }
                $ar['name'] = $detail->product->name;
            }

            $total += $detail->price;
        @endphp
    @endforeach
        <tr>
            <td>{{$i}}</td>
            <td width="20">{{ $order->code }}</td>
            <td width="20">{{ $order->user->name }}</td>
            <td width="20">{{ $attrs['name'] ?? ($ar['name'] ?? '') }}</td>
            <td width="20">{{ $order->print_machine ?? 'Không có' }}</td>
            <td width="20">{{ $order_detail->quantity }}</td>
            <td width="20">{{ $order_detail->price }}</td>
            <td width="20">{{formatDate($order->created_at)}}</td>
            <td width="20">{{$order->note}}</td>
            <td width="20">{{$order->staff ? $order->staff->name : 'Không'}}</td>
            <td width="20">{!! formatStatus($order->status) !!}</td>
        </tr>
    @php
        $i++;
    @endphp
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b>Tổng cộng:</b></td>
        <td>{{$total}}</td>
    </tr>
    </tbody>
</table>
