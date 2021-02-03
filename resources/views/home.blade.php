<x-default-layout>
    @foreach($layouts as $layout)
    <section class="my-2">
        @if($layout->component != null)
            @include($layout->component)
        @else
            <div class="card">
                <div class="card-body">
                    @foreach($layout->menus as $menu)
                    <h4>{{$menu->page->title}}</h4>
                    <div class="row">
                        <div class="col-12">
                            {!! $menu->page->content !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            <div>
        @endif
    </section>
    @endforeach
</x-default-layout>
