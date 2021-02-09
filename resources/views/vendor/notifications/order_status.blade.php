@component('mail::message')

Đây là thư thông báo về đơn hàng số #<strong>{{$order_code}}</strong> của bạn đã được chuyển sang trạng thái {!! $order_status !!}

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
