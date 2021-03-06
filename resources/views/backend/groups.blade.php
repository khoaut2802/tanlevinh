<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Groups') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div style='border-bottom: 2px solid #eaeaea'>
                        <ul class='flex cursor-pointer'>
                          <li class='py-2 px-6 rounded-t-lg @if(request()->routeIs('products')) bg-gray-100 @else bg-white @endif'><a href="{{route('products')}}">Danh sách sản phẩm</a></li>
                          <li class='py-2 px-6 rounded-t-lg @if(request()->routeIs('groups')) bg-gray-100 @else bg-white @endif'><a href="{{route('groups')}}">Nhóm sản phẩm</a></li>
                        </ul>
                    </div>
                    <div class="py-8">
                        <div class="my-2 flex sm:flex-row flex-col justify-between items-center">
                            <form method="POST" action="{{route('group_search')}}" class="flex">
                                @csrf
                            <div class="flex flex-row mb-1 sm:mb-0">
                                <div class="relative">
                                    <select
                                        name="per_page"
                                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="20">20</option>
                                    </select>
                                </div>
                            </div>
                            <div class="block relative">
                                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                                        <path
                                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                                        </path>
                                    </svg>
                                </span>
                                <input placeholder="Search" name="search" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                                <input type="submit" class="hidden" value="submit">
                            </div>
                            </form>
                            <button type="button" 
                            class="bg-blue-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 modal"
                            data-target="#add_group_modal"
                            >
                                <i class="ri-add-box-line"></i> Thêm nhóm
                            </button>                            
                        </div>
                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tên nhóm
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tổng số sản phẩm
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Hình ảnh
                                            </th>    
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Kiểu ảnh
                                            </th>  
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Sắp xếp
                                            </th>                                                                                                                              
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tạo lúc
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Hành động
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($groups['data'] as $group)
                                        <tr>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{$group['name']}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">{{count($group['products'])}}</p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap"><img src="{{asset($group['image'])}}" class="img-responsive" width="100"/></p>
                                            </td>   
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">{{$group['image_type'] == 'card' ? 'Vuông' : 'Chữ nhật'}}</p>
                                            </td>      
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <form method="POST" action="{{route('group_order', ['id' => $group['id']])}}">
                                                    @csrf
                                                    <input type="number" name="order" class="text-gray-900 whitespace-no-wrap w-20" value="{{$group['order']}}">
                                                    <input type="submit" class="hidden" value="submit">
                                                </form>
                                            </td>                                                                                    
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{formatDate($group['created_at'])}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <button type="button" 
                                                class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 groupEdit"
                                                data-id="{{$group['id']}}" >
                                                    Sửa
                                                </button>                                                 
                                                <button type="button" 
                                                class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 groupDelete"
                                                data-id="{{$group['id']}}">
                                                    Xóa
                                                </button> 
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                            <p>No group found.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div
                                    class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                                    <span class="text-xs xs:text-sm text-gray-900">
                                        Bạn đang ở trang {{$groups['current_page']}} / {{$groups['last_page']}} trên tổng số {{$groups['total']}} nhóm
                                    </span>
                                    <div class="inline-flex mt-2 xs:mt-0">
                                        <a  href="{{route('groups', ['page' => $groups['current_page'] - 1 <= 0 ? 1 : $groups['current_page'] - 1])}}"
                                            class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                            Trước
                                        </a>
                                        <a  href="{{route('groups', ['page' => $groups['current_page'] + 1 > $groups['last_page'] ? $groups['last_page'] : $groups['current_page'] + 1])}}"
                                            class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                                            Sau
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="add_group_modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form method="post" id="add_group_form">
                @csrf
                <input type="hidden" name="group_id">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                        Tạo / Chỉnh sửa nhóm sản phẩm
                    </h3>
                    <div class="mt-2">
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên nhóm" required>
                        </div>
                        <div class="relative flex w-full flex-wrap items-stretch mb-3">
                            <textarea name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3" placeholder="Mô tả" required></textarea>
                        </div>  
                        <div class="flex content-between items-center my-2">
                            <label class="mr-5 w-1/3">Kiểu ảnh:</label>
                            <select name="image_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="card">Vuông</option>      
                                <option value="banner">Chữ nhật</option>                   
                            </select>  
                        </div>
                        <div class="flex content-between items-center my-2">
                            <label class="mr-5 w-1/3">Ảnh đại diện:</label>
                            <input type="file" name="image" id="upload_image" class="mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>                                                                     
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Lưu thay đổi
                </button>
                <button type="button" 
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#add_group_modal">
                    Cancel
                </button>
                </div>
            </form>
          </div>
        </div>
      </div>   

</x-app-layout>
