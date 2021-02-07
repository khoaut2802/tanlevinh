<x-default-layout>
    <div class="my-2 row no-gutters">
    @foreach($groups as $group)
    <div class="@if($group->image_type == 'card'){{'col-6 col-sm-3'}}@else{{'col-12'}}@endif p-2">
		<figure class="card card-product-grid">
            <a href="{{route('group', ['slug' => $group->slug])}}">
                <div class="img-wrap"> <img src="{{asset($group->image)}}"> </div>
                @if($group->image_type == 'card')
                <figcaption class="info-wrap border-top">
                    <span class="title">{{$group->name}}</span>
                </figcaption>
                @endif
            </a>
        </figure>
	</div>
    @endforeach
</div>
</x-default-layout>
