@component('mail::message')

Đây là thư thông báo về đơn hàng số #<strong>{{$order->code}}</strong> vừa được khởi tạo. Vui lòng kiểm tra!

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
