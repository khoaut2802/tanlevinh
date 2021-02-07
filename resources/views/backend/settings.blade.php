<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banners') }}
        </h2>
    </x-slot>
    <section>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-lg py-6">
                    <div class="block overflow-x-auto mx-6">                      
                        <form method="POST" action="{{route('settings_update')}}">
                            @csrf
                            @foreach($settings as $setting)
                            @if($setting->type == 'text')
                                <label class="block my-3">
                                    <span class="text-gray-700">{{__('settings.'.$setting->key)}}</span>
                                    <input type="text" name="{{$setting->key}}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{$setting->value}}">
                                </label>         
                            @else
                                <label class="block items-center my-3">
                                    <input type="checkbox" name="{{$setting->key}}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" @if($setting->value == 'on') checked="" @endif>
                                    <span class="ml-2">{{__('settings.'.$setting->key)}}</span>
                                </label>
                            @endif
                            @endforeach
                            <div class="my-3">
                                <button type="submit" class="w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</x-app-layout>
