<x-default-layout>
    <div class="row no-gutters">
    @foreach($groups as $group)
    <div class="@if($group->image_type == 'card'){{'col-6 col-sm-3 pl-2 pr-2'}}@else{{'col-12'}}@endif">
        @if($group->image_type != 'card')
            <div class="dot-line"></div>
        @endif
		<figure class="card card-product-grid mb-0 border-0 bg-transparent">
            <a href="{{route('group', ['slug' => $group->slug])}}">
                <div class="img-wrap"> <img src="{{asset($group->image)}}"> </div>
                @if($group->image_type == 'card')
                <figcaption class="info-wrap border-0">
                    <span class="title">{{$group->name}}</span>
                </figcaption>
                @endif
            </a>
        </figure>
	</div>
    @endforeach
</div>
</x-default-layout>
