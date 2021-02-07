<x-default-layout>
    <div class="my-2 row" id="main-div">
    <div class="col-12 my-2">
        <h3>{{$product->product_group->name}} / {{$product->name}}:</h3>
    </div>
    <div class="col-12 col-sm-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h4>Chọn thuộc tính cho sản phẩm:</h4>
                    <form method="POST" action="{{route('orders_create')}}" id="createOrderForm">
                    @foreach($product->attributes as $attr)
                        <input type="hidden" name="attr_{{$attr->attr_id}}" value="{{json_decode($attr->values)[0]}}">
                        <div class="d-flex justify-content-left align-items-center my-3">
                            <span class="attr-name font-weight-bold">{{$attr->attr->name}}</span>
                            @if($attr->attr->type == 'select')
                            <select class="form-control" name="attr_{{$attr->attr_id}}">
                                @foreach(json_decode($attr->values) as $option)
                                    @php
                                        $attrDetail = getAttrValue($attr->attr_id, $option);
                                    @endphp
                                    <option value="{{$option}}" data-price="{{$attrDetail->price}}">{{$attrDetail->name}}</option>
                                @endforeach
                            </select>
                            @elseif($attr->attr->type == 'card')
                                @foreach(json_decode($attr->values) as $option)
                                    @php
                                        $attrDetail = getAttrValue($attr->attr_id, $option);
                                    @endphp
                                    <div class="card-attr @if($loop->first){{'active'}}@endif" data-attr="{{$attr->attr_id}}" data-option="{{$option}}" data-price="{{$attrDetail->price}}">
                                        <p>{{$attrDetail->name}}</p>
                                    </div>                                
                                @endforeach                        
                            @endif
                        </div>
                    @endforeach
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
                        <dd style="flex-grow: 1" class="text-right">$69.97</dd>
                      </dl>
                      <dl class="d-flex">
                        <dt style="width: 150px">Discount:</dt>
                        <dd style="flex-grow: 1"class="text-right text-danger">- $10.00</dd>
                      </dl>
                      <dl class="d-flex">
                        <dt style="width: 150px">Total:</dt>
                        <dd style="flex-grow: 1" class="text-right text-dark b"><strong>$59.97</strong></dd>
                      </dl>
                      <hr>
                      <textarea class="form-control" placeholder="Ghi chú"></textarea>
                      <div class="input-group mb-3 mt-2">
                        <input type="text" class="form-control" name="" placeholder="Mã giảm giá (nếu có)">
                        <span class="input-group-append"> 
                            <button class="btn btn-primary">Ok</button>
                        </span>
                      </div>

                      <a href="#" class="btn btn-primary btn-block">Đặt hàng</a>                    
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
            $('.card-attr').on('click', function() {
                var id = $(this).attr('data-attr');
                var price = $(this).attr('data-price');
                var option = $(this).attr('data-option');

                $('.card-attr').each(function() {
                    if($(this).attr('data-attr') == id)
                        $(this).removeClass('active')
                })

                $(this).addClass('active');
                $('input[name="attr_'+id+'"]').val(option)
            })
        </script>
    </x-slot>
</x-default-layout>
