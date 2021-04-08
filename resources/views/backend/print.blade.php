<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$order->code}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            background: #eee;
        }

        .invoice {
            background: #fff;
            padding: 20px
        }

        .invoice-company {
            font-size: 20px
        }

        .invoice-header {
            margin: 0 -20px;
            background: #f0f3f4;
            padding: 20px
        }

        .invoice-date,
        .invoice-from,
        .invoice-to {
            display: table-cell;
            width: 1%
        }

        .invoice-from,
        .invoice-to {
            padding-right: 20px
        }

        .invoice-date .date,
        .invoice-from strong,
        .invoice-to strong {
            font-size: 16px;
            font-weight: 600
        }

        .invoice-date {
            text-align: right;
            padding-left: 20px
        }

        .invoice-price {
            background: #f0f3f4;
            display: table;
            width: 100%
        }

        .invoice-price .invoice-price-left,
        .invoice-price .invoice-price-right {
            display: table-cell;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            width: 75%;
            position: relative;
            vertical-align: middle
        }

        .invoice-price .invoice-price-left .sub-price {
            display: table-cell;
            vertical-align: middle;
            padding: 0 20px
        }

        .invoice-price small {
            font-size: 12px;
            font-weight: 400;
            display: block
        }

        .invoice-price .invoice-price-row {
            display: table;
            float: left
        }

        .invoice-price .invoice-price-right {
            width: 25%;
            background: #2d353c;
            color: #fff;
            font-size: 28px;
            text-align: right;
            vertical-align: bottom;
            font-weight: 300
        }

        .invoice-price .invoice-price-right small {
            display: block;
            opacity: .6;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px
        }

        .invoice-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px
        }

        .invoice-note {
            color: #999;
            margin-top: 80px;
            font-size: 85%
        }

        .invoice>div:not(.invoice-footer) {
            margin-bottom: 20px
        }

        .btn.btn-white,
        .btn.btn-white.disabled,
        .btn.btn-white.disabled:focus,
        .btn.btn-white.disabled:hover,
        .btn.btn-white[disabled],
        .btn.btn-white[disabled]:focus,
        .btn.btn-white[disabled]:hover {
            color: #2d353c;
            background: #fff;
            border-color: #d9dfe3;
        }

        .table tr, .table th, .table td {
            padding: 0.75rem 0;
            border: 2px solid rgb(216, 211, 211) !important
        }

    </style>
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="col-md-12">
            <div class="d-print-none d-flex justify-content-between align-items-center mb-3">
                <a href="{{route('orders')}}">Quay lại</a>
                <span class="hidden-print">
                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i
                            class="fa fa-print t-plus-1 fa-fw fa-lg"></i> In</a>
                </span>
            </div>
            <div class="invoice">
                <!-- begin invoice-company -->
                <div class="invoice-company d-flex justify-content-between align-items-center text-inverse f-w-600">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('/assets/images/logo.png')}}" height="80" class="mr-3">
                        <div class="d-flex flex-column">
                            <h6>{{getSetting('company_name')}}</h6>
                            <span style="font-size: 14px"><i class="fa fa-map-marker mr-2" style="font-size: 16px"></i> {{getSetting('company_address')}}</span>
                            <span style="font-size: 14px"><i class="fa fa-phone mr-2"></i> {{getSetting('company_phone')}}</span>
                            <span style="font-size: 14px"><i class="fa fa-paper-plane mr-2" style="font-size: 12px"></i> {{getSetting('company_email')}}</span>
                            <span style="font-size: 14px"><i class="fa fa-skype mr-2"></i> tanlevinh</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <h4 class="font-weight-bold">PHIẾU SẢN XUẤT</h4>
                        <h5 class="font-weight-bold">MÁY SẢN XUẤT: {{$order->print_machine ?? 'Chưa có'}}</h5>
                        <p class="small">Ngày: {{\Carbon\Carbon::now()->format('d-m-Y')}}</p>
                    </div>
                </div>
                <!-- end invoice-company -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <span class="font-weight-bold">Khách hàng: {{$order->user->name}}</span>
                    </div>
                    <div>
                        <span class="font-weight-bold">Số phiếu: {{\Carbon\Carbon::now()->format('dmYhis')}}</span>
                    </div>
                </div>
                <!-- begin invoice-content -->
                <div class="invoice-content">
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
                    <!-- begin table-responsive -->
                    <div class="table-responsive">
                        @foreach($order->detail as $key => $item)
                        <table class="table">
                            <tbody class="text-gray-700">
                            @if($item->product_id != 0)
                            <tr class="text-center border">
                                <th class="border">
                                    Tên sản phẩm:
                                </th>
                                <td class="border-right border-black">{{$item->product->name}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach(array_chunk(json_decode($item->product_attrs),2) as $attrs)
                            <tr class="text-center border border-green-900">
                                @foreach($attrs as $key => $attr)
                                        <th class="border">{{$attr->name}}:</th>
                                        <td @if($key % 2 == 0)class="border-right border-black"@endif>{{$attr->values->name}} ({{is_numeric($attr->values->price) ? number_format($attr->values->price).'đ' : $attr->values->price}})</td>
                                @endforeach
                                @if($loop->last)
                                    <th class="border">Số lượng</th> <td>{{$item->quantity}}</td>
                                @endif
                            </tr>
                            @endforeach
                            <tr class="text-center border border-green-900"> <th class="border">Giá</th> <td class="border-right border-black">{{number_format($price)}}đ</td> <td></td><td></td></tr>
                            @else
                                @if(strpos($order['code'], 'IMP') !== false || strpos($order['code'], 'PATRON') !== false)
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach(json_decode($item['product_attrs']) as $key => $value)
                                        <tr class="text-center border border-green-900">
                                            <th class="border-right border-black">{{__($key)}}</th>
                                            <td class="px-2">{{$value}}</td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            @endif
                            </tbody>
                        </table>
                    @endforeach
                    </div>
                    <!-- end table-responsive -->
                </div>
                <!-- end invoice-content -->
                {{-- <!-- begin invoice-note -->
                <div class="invoice-note">
                    * Make all cheques payable to [Your Company Name]<br>
                    * Payment is due within 30 days<br>
                    * If you have any questions concerning this invoice, contact [Name, Phone Number, Email]
                </div>
                <!-- end invoice-note -->
                <!-- begin invoice-footer -->
                <div class="invoice-footer">
                    <p class="text-center m-b-5 f-w-600">
                        THANK YOU FOR YOUR BUSINESS
                    </p>
                    <p class="text-center">
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> matiasgallipoli.com</span>
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T:016-18192302</span>
                        <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> rtiemps@gmail.com</span>
                    </p>
                </div>
                <!-- end invoice-footer --> --}}
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>
