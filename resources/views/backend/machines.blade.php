<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Máy sản xuất') }}
        </h2>
    </x-slot>
    <section>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-lg py-6">
                    <div class="block overflow-x-auto mx-6">
                        <div class="float-right mb-2">
                            <button class="rounded-md border border-transparent shadow-sm bg-green-700 text-white px-2 modal" data-target="#add_machine_modal">
                                Thêm máy mới
                            </button>
                        </div>                        
                        <table class="w-full text-left rounded-lg">
                            <thead>
                                <tr class="text-gray-800 border border-b-0">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Tên máy</th>
                                    <th class="px-4 py-3">Ngày tạo</th>
                                    <th class="px-4 py-3">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($machines as $machine)
                                    <tr class="w-full font-light text-gray-700 bg-gray-100 whitespace-no-wrap border border-b-0">
                                        <td class="px-4 py-4">{{$machine->id}}</td>                                     
                                        <td class="px-4 py-4">{{$machine->name}}</td>
                                        <td class="px-4 py-4">{{\Carbon\Carbon::parse($machine->created_at)->format('m/d/Y H:i:s')}}</td>
                                        <td class="py-4">
                                            <form method="post" action="{{route('machine.delete', ['id' => $machine->id])}}">
                                                @csrf
                                                <button type="submit" class="rounded-md border border-transparent shadow-sm bg-red-700 text-white px-2">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="add_machine_modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form method="post" action="{{route('machine.store')}}">
                @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Thêm Máy sản xuất
                  </h3>
                  <div class="mt-2">
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên máy" required>
                    </div>
                  </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Lưu
              </button>
              <button type="button" 
              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#add_machine_modal">
                Cancel
              </button>
            </div>
            </form>
          </div>
        </div>
      </div> 
    </section>
</x-app-layout>
