<x-user-layout>
    <div class="my-2 row no-gutters">
    <div class="col-12">
        <h3>Kết quả tìm kiếm: </h3>
    </div>
    @foreach($results as $product)
    <div class="col-6 col-sm-3 p-2">
		<figure class="card card-product-grid">
            <a href="{{route('product', ['slug' => $product->slug])}}">
                <div class="img-wrap"> <img src="{{asset($product->image)}}"> </div>
                <figcaption class="info-wrap border-top">
                    <span class="title">{{$product->name}}</span>
                </figcaption>
            </a>
        </figure>
	</div>
    @endforeach
</div>
</x-user-layout>
