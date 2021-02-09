<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Page') }}
        </h2>
    </x-slot>
    <section>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-lg py-6">
                    <div class="block overflow-x-auto mx-6">  
                        <form method="POST" action="{{route('pages.create')}}">    
                            @csrf
                        <input type="hidden" name="page_id" value="{{request()->route('id')}}">               
                        <label class="block">
                            <span class="text-gray-700">Tiêu đề:</span>
                            <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" value="{{$page['title'] ?? ''}}">
                        </label>
                        <label class="block my-3">
                            <span class="text-gray-700">Nội dung:</span>
                            <textarea name="content" id="editor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{$page['content'] ?? ''}}</textarea>
                            <script>
                                CKEDITOR.replace( 'editor' );
                            </script>
                        </label>
                        <div class="float-right">
                        <button type="submit" class="rounded-md border border-transparent shadow-sm bg-green-700 text-white px-5 py-2">
                            Lưu
                        </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <x-slot name="script">
        <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    </x-slot>
</x-app-layout>
