<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('components.alert')
                    <div style='border-bottom: 2px solid #eaeaea'>
                        <ul class='flex cursor-pointer'>
                          <li class='py-2 px-6 rounded-t-lg @if(request()->routeIs('users')) bg-gray-100 @else bg-white @endif'><a href="{{route('users')}}">Danh sách người dùng</a></li>
                        </ul>
                    </div>
                    <div class="py-8">
                        <div class="my-2 flex sm:flex-row flex-col justify-between items-center">
                            <form method="GET" action="{{route('users')}}" class="flex">
                                @csrf
                            <div class="flex flex-row mb-1 sm:mb-0">
                                <div class="relative">
                                    <select
                                        name="per_page"
                                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                        <option value="5" @if(request()->query('per_page') == 5)selected @endif>5</option>
                                        <option value="10" @if(request()->query('per_page') == 10)selected @endif>10</option>
                                        <option value="20" @if(request()->query('per_page') == 20)selected @endif>20</option>
                                        <option value="50" @if(request()->query('per_page') == 50)selected @endif>20</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <select
                                        name="user_type"
                                        class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                        <option value="">All</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Người dùng</option>
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
                            data-target="#add_user_modal"
                            >
                                <i class="ri-add-box-line"></i> Tạo người dùng
                            </button>
                        </div>
                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Tên người dùng
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Đơn hàng đã tạo
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Loại nguời dùng
                                            </th>
                                            <th
                                                class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                                Ngày tạo tài khoản
                                            </th>
                                            <th
                                            class="px-5 py-3 border-b-2 border-r-2 border-blue-200 bg-blue-700 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                            Hành động
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users['data'] as $user)
                                        <tr>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{$user['name']}}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">{{$user['email']}}</p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$user['orders_count']}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{$user['user_type']}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{formatDate($user['created_at'])}}
                                                </p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                                <form method="POST" action="{{route('users_delete', ['id' => $user['id']])}}">
                                                    @csrf
                                                    <a href="javascript:;"
                                                    class="bg-yellow-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 editUser" data-id="{{$user['id']}}"
                                                    >
                                                        Sửa
                                                    </a>                                                 
                                                    <button type="submit" 
                                                    class="bg-red-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1"
                                                    >
                                                        Xóa
                                                    </button> 
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                            <p>No product found.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div
                                    class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                                    <span class="text-xs xs:text-sm text-gray-900">
                                        Bạn đang ở trang {{$users['current_page']}} / {{$users['last_page']}} trên tổng số {{$users['total']}} sản phẩm
                                    </span>
                                    <div class="inline-flex mt-2 xs:mt-0">
                                        <a  href="{{route('users', ['page' => $users['current_page'] - 1 <= 0 ? 1 : $users['current_page'] - 1])}}"
                                            class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                            Trước
                                        </a>
                                        <a  href="{{route('users', ['page' => $users['current_page'] + 1 > $users['last_page'] ? $users['last_page'] : $users['current_page'] + 1])}}"
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

<div class="hidden fixed z-10 inset-0 overflow-y-auto" id="add_user_modal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <form method="post" action="{{route('users_create')}}">
            @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Tạo người dùng
                </h3>
                <div class="mt-2">
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên người dùng" required>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập email" required>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="password" name="password" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập mật khẩu" required>
                    </div>   
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="tel" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Số điện thoại"required>
                    </div>             
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Địa chỉ"required>
                    </div> 
                    <label class="block">
                        <span class="text-gray-700">Loại tài khoản:</span>
                        <select name="user_type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                          <option value="user">Người dùng</option>
                          <option value="admin">Admin</option>
                        </select>
                     </label> 
                     <label class="inline-flex items-center my-3">
                        <input type="checkbox" name="patron" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2">Khách quen</span>
                      </label>                    
                </div>
            </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Tạo
          </button>
          <button type="button" 
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#add_user_modal">
            Hủy bỏ
          </button>
        </div>
        </form>
      </div>
    </div>
  </div> 
  
  <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="edit_user_modal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <form method="post" action="{{route('users_update')}}">
            @csrf
            <input type="hidden" name="id">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Chỉnh sửa người dùng
                </h3>
                <div class="mt-2">
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên người dùng" required>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập email" required>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="password" name="password" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập mật khẩu">
                    </div>   
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="tel" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Số điện thoại"required>
                    </div>             
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Địa chỉ"required>
                    </div> 
                    <label class="block">
                        <span class="text-gray-700">Loại tài khoản:</span>
                        <select name="user_type" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                          <option value="user">Người dùng</option>
                          <option value="admin">Admin</option>
                        </select>
                     </label>     
                     <label class="inline-flex items-center my-3">
                        <input type="checkbox" name="patron" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2">Khách quen</span>
                      </label>                     
                </div>
            </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Lưu thay đổi
          </button>
          <button type="button" 
          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#edit_user_modal">
            Hủy bỏ
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>  
</x-app-layout>
