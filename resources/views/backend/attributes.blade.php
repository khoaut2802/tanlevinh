<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attributes') }}
        </h2>
    </x-slot>
    <section>
    <div class="py-12" x-data="{addition: []}">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="rounded-lg shadow-lg py-6">
                    <div class="block overflow-x-auto mx-6">                      
                        <form method="POST" action="{{route('attributes_update')}}">
                            @csrf
                            <div x-data="initAttr({{$selected_attr->id}})" class="flex items-center">
                                <div class="mr-3">
                                    <select @change="window.location.href = '{{route('attributes')}}?attr=' + $event.target.value" class="block rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="attr">
                                        @foreach($attrs as $attr)
                                            <option value="{{$attr->id}}" @if($selected_attr->id == $attr->id) selected @endif>{{$attr->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mr-3">
                                    <button type="button" class="w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm modal" data-target="#addAttrModal">
                                       + Thêm
                                    </button>
                                </div>    
                                <div>
                                    <button @click="deleteAttr()" type="button" class="w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                        Xóa
                                    </button>  
                                </div>
                            </div>
                            @foreach(json_decode($selected_attr->options) as $key => $value)
                                <template x-data="initAttr({{$selected_attr->id}})" x-if="show">
                                <div class="flex content-between items-center my-2">
                                    <input type="text" name="option_{{$key}}_name" class="focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md mr-3" value="{{$value->name}}">
                                    <input type="text" name="option_{{$key}}_price" class="focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md" value="{{$value->price}}"> 
                                    <button type="button" @click="deleteAttrValue({{$key}})" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-red text-red-500 sm:text-sm rounded-md">
                                        Xóa
                                    </button>                                  
                                </div>  
                                </template>
                            @endforeach 
                            <div>
                                <template x-for="(item, index) in addition" :key="index">
                                    <div class="flex content-between items-center my-2">
                                        <input type="text" :name="`addition_${index}_name`" class="focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md mr-3" placeholder="tên">
                                        <input type="text" :name="`addition_${index}_price`" class="focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md" placeholder="giá tiền"> 
                                        <button type="button" @click="delete addition[index]" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-red text-red-500 sm:text-sm rounded-md">
                                            Xóa
                                        </button>                                  
                                    </div>  
                                </template>   
                            </div>                         
                            <button @click="addition.push({'name': 'default', 'price' : 0})" type="button" class="w-full my-2 justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                + Thêm giá trị
                            </button>
                            <div class="my-3">                                
                                <button type="submit" class="w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                    Lưu thay đổi
                                </button>                              
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="addAttrModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form method="post" action="{{route('attributes_add')}}">
                @csrf
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Thêm thuộc tính
                  </h3>
                  <div class="mt-2">
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nhập tên thuộc tính" required>
                    </div>
                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                        <label class="block">Kiểu giao diện: </label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="type">
                            <option value="card">Thẻ</option>   
                            <option value="select">Danh sách</option>                    
                        </select>
                    </div>
                  </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Tạo
              </button>
              <button type="button" 
              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm modal-close" data-target="#add_product_modal">
                Cancel
              </button>
            </div>
            </form>
          </div>
        </div>
      </div>   

    <x-slot name="script">
        <script>
            function initAttr(attr) {
                return {
                    show: true,
                    deleteAttr() {
                        fetch('{{route('attributes_delete')}}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{csrf_token()}}' },
                            body: JSON.stringify({attr: attr, value: 'none'})
                        })
                        .then((resp) => {
                            if(resp.status == 200) {
                                window.location.href = '{{route('attributes')}}'
                            }
                        })                        
                    },
                    deleteAttrValue(key = 'none') {
                        fetch('{{route('attributes_delete')}}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{csrf_token()}}' },
                            body: JSON.stringify({attr: attr, value: key})
                        })
                        .then((resp) => {
                            if(resp.status == 200) {
                                this.show = false
                            }
                        })
                    }
                }
            }
        </script>
    </x-slot>

</x-app-layout>
