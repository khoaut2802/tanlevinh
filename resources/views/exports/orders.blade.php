<table>
    <thead>
    <tr>
        <th><b>STT</b></th>
        <th><b>Mã đơn hàng</b></th>
        <th><b>Người đặt</b></th>
        <th><b>Email</b></th>
        <th><b>Số tiền</b></th>
        <th><b>Trạng thái</b></th>
        <th><b>Ngày đặt</b></th>
    </tr>
    </thead>
    <tbody>
    @php
        $i = 1;
        $total = 0;
    @endphp
    @foreach($orders as $order)
        <tr>
            <td>{{$i}}</td>
            <td width="20">{{ $order->code }}</td>
            <td width="20">{{ $order->user->name }}</td>
            <td width="20">{{ $order->user->email }}</td>
            <td width="20">
                @foreach($order->detail as $detail)
                    {{$detail->price}}
                    @php
                        $total += $detail->price;
                    @endphp
                @endforeach
            </td>
            <td width="20">{!! formatStatus($order->status) !!}</td>
            <td width="20">{{formatDate($order->created_at)}}</td>
        </tr>
    @php
        $i++;
    @endphp
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Tổng cộng:</td>
        <td>{{$total}}</td>
    </tr>
    </tbody>
</table>
