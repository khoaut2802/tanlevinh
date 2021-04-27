<x-default-layout>
    @php
        $sumTotal = $product->price ?? 0;
        $attrPrice = 0;
    @endphp
    <div class="my-2 row" id="main-div">
    <div class="col-12 my-2">
        <h3>{{$product->product_group->name}} / {{$product->name}}:</h3>
    </div>
    <div class="col-12 col-sm-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h4>Chọn thuộc tính cho sản phẩm:</h4>
                    <form method="POST" action="{{route('cart.add')}}" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                    @foreach($product->attributes as $attr)

                        <input type="hidden" name="attr_{{$attr->attr_id}}" value="{{json_decode($attr->values)[0]}}">
                        <div class="d-flex justify-content-left align-items-center my-3">
                            <span class="attr-name font-weight-bold">{{$attr->attr->name}}</span>
                            @if($attr->attr->type == 'select')
                            <select class="form-control" name="attr_{{$attr->attr_id}}">
                                @foreach(json_decode($attr->values) as $key => $value)
                                    @php
                                        $attrDetail = getAttrValue($attr->attr_id, $value);
                                        if($key == 0)
                                            $attrPrice = $attrPrice + $attrDetail->price;
                                    @endphp
                                    <option value="{{$value}}" data-price="{{$attrDetail->price ?? 0}}">{{$attrDetail->name}}</option>
                                @endforeach
                            </select>
                            @elseif($attr->attr->type == 'card')
                                @foreach(json_decode($attr->values) as $key => $value)
                                    @php
                                            $attrDetail = getAttrValue($attr->attr_id, $value);
                                            if($key == 0)
                                                $attrPrice = $attrPrice + $attrDetail->price;
                                    @endphp
                                    <div class="card-attr @if($loop->first){{'active'}}@endif" data-attr="{{$attr->attr_id}}" data-option="{{$value}}" data-price="{{$attrDetail->price ?? 0}}">
                                        <p>{{$attrDetail->name}}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-left align-items-center my-3">
                        <span class="attr-name font-weight-bold">Số lượng ({{ucfirst($product->unit)}})</span>
                        <select class="form-control" name="qty" id="qty">
                            @foreach(explode(',',$product->min_qty) as $qty)
                                <option value="{{$qty}}">{{$qty}}</option>
                            @endforeach
                                <option value="other">Số khác</option>
                        </select>
                        <input type="number" name="custom_qty" id="custom_qty" min="1" class="form-control ml-2" style="display: none" value="1">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div id="sticky-card">
            <div class="card">
                <div class="card-body">
                    <h4>Tóm tắt đơn hàng:</h4>
                    <dl class="d-flex">
                        <dt style="width: 150px">Total price:</dt>
                        <dd style="flex-grow: 1" class="text-right" id="sumTotal">0</dd>
                      </dl>
                      <hr>
                      <button type="button" class="btn btn-primary btn-block" id="addToCart">Thêm vào giỏ hàng</button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap">
                           <a href="#"><img src="{{asset($product->image)}}"></a>
                        </div> <!-- img-big-wrap.// -->
                        @if(count($product->images) > 0)
                        <div class="thumbs-wrap">
                          <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/9.jpg"></a>
                          <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/10.jpg"></a>
                          <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/7.jpg"></a>
                          <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/8.jpg"></a>
                        </div> <!-- thumbs-wrap.// -->
                        @endif
                    </article>
                </div>
            </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            var product_price = {{$sumTotal}};

            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'VND',
            });

            refreshPrice();

            $('.card-attr').on('click', function() {
                var id = $(this).attr('data-attr');
                var price = parseInt($(this).attr('data-price'));
                var option = $(this).attr('data-option');

                $('.card-attr').each(function() {
                    if($(this).attr('data-attr') == id)
                        $(this).removeClass('active')
                })

                $(this).addClass('active');
                $('input[name="attr_'+id+'"]').val(option)
                refreshPrice()
            })


            $('#addToCart').on('click', function() {
                var qty = $('#qty').val()

                if(qty == 'other') {
                    qty = $('#custom_qty').val()
                }

                if(qty > 0 && Number.isInteger(parseInt(qty)) == true) {
                    $('#addToCartForm').submit();
                } else {
                    alert('Số lượng phải lớn hơn 0')
                }
            })

            $('select[name="qty"]').on('change', function() {
                if($(this).val() == 'other') {
                    $('#custom_qty').show()
                } else {
                    $('#custom_qty').hide()
                }
                refreshPrice()
            })

            $('#custom_qty').on('input', function() {
                refreshPrice()
            })

            function refreshPrice() {
                var attr_price = 0;
                var qty = $('#qty').val()

                if(qty == 'other') {
                    qty = $('#custom_qty').val()
                }

                $('.card-attr').each(function() {
                    if($(this).hasClass('active'))
                    attr_price = attr_price + parseInt($(this).attr('data-price'))
                })

                $('#sumTotal').text(formatter.format((product_price + attr_price ) * parseInt(qty)))
            }
        </script>
    </x-slot>
</x-default-layout>
