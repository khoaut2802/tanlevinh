<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="grid md:grid-cols-2 sm:grid-cols gap-4">
                <div class="flex justify-center">
                    <div class="bg-white shadow-xl rounded-lg w-full">
                        <form method="post" action="{{route('menu_add')}}">
                            @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4" 
                        x-data={showPages:false,menuType:'link'}
                        x-init="$watch('menuType', (e) => { 
                        if(e == 'page') 
                            showPages = true 
                        else 
                            showPages = false })"
                        >
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                               Thêm Menu
                              </h3>
                              <div class="mt-2">
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên menu" required>
                                </div>
                                <label class="block">
                                    <span class="text-gray-700">Loại Menu</span>
                                    <select x-model="menuType" name="type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                      <option value="page">Trang</option>
                                      <option value="link">Liên kết</option>
                                    </select>
                                </label>
                                <label class="block my-2" x-show="showPages">
                                    <span class="text-gray-700">Chọn trang</span>
                                    <select name="page" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :required="showPages == true">
                                      <option value="">Chọn trang</option>
                                      @foreach($pages as $page)
                                        <option value="{{$page->id}}">{{$page->title}}</option>
                                      @endforeach
                                    </select>
                                </label> 
                                <label class="block my-2" x-show="showPages != true">
                                    <span class="text-gray-700">Nhập liên kết</span>
                                    <input type="text" name="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="http://example.com" :required="showPages != true">
                                </label>                                                              
                              </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Thêm
                          </button>
                        </div>
                        </form>                            
                    </div>
                </div>                
                <div class="flex justify-center">
                    <div class="bg-white shadow-xl rounded-lg w-full">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Danh sách Menu
                            </h3>

                            <div class="w-full my-4">
                                @foreach($data as $menu)
                                    <div x-data={show:false} class="rounded-sm">
                                        <div class="border border-b-0 bg-gray-100 px-10 py-3 flex justify-between items-center" id="headingOne">
                                            <button @click="show=!show" class="text-blue-500 hover:text-blue-700 focus:outline-none" type="button">
                                            {{$menu['name']}}
                                            </button>
                                            @if($menu['type'] != 'product')
                                            <form action="{{route('menu_delete', ['id' => $menu['id']])}}" method="POST">
                                                @csrf
                                                <button type="submit" class="rounded-md border border-transparent shadow-sm bg-red-700 text-white px-2">
                                                    Xóa
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                        @if(count($menu['childrens']) > 0)
                                        <div x-show="show" class="border border-b-0 px-10 py-3">
                                            @foreach($menu['childrens'] as $submenu)
                                            <div class="border border-b-0 bg-gray-100 px-10 py-3 flex justify-between items-center">
                                                <button class="text-blue-500 hover:text-blue-700 focus:outline-none" type="button">
                                                    {{$submenu['name']}}
                                                </button>
                                                @if($submenu['type'] != 'product')
                                                <form action="{{route('menu_delete', ['id' => $submenu['id']])}}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="rounded-md border border-transparent shadow-sm bg-red-700 text-white px-2">
                                                        Xóa
                                                    </button>
                                                </form>
                                                @endif                                                
                                            </div>       
                                            @endforeach                               
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>