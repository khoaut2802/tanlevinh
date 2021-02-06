<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Product') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('components.alert')
                    <form method="POST" id="updateProductForm">
                    @csrf
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3"></label>
                            <img src="{{asset($product['image'])}}" width="200px">
                        </div>                      
                    </div>                      
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3">Ảnh đại diện:</label>
                            <input type="file" name="image" id="upload_image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>                      
                    </div>  
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3">Tên sản phẩm:</label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{$product['name']}}" required>
                        </div>                      
                    </div>
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3">Mô tả:</label>
                            <textarea type="text" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{$product['description']}}</textarea>
                        </div>                      
                    </div>
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3">Thuộc nhóm:</label>
                            <select class="select2" name="group_id" class="mb-3">
                                @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{ $group->name }}</option>
                                @endforeach                        
                            </select>  
                        </div>                      
                    </div>                  
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <hr class="border-2">   
                    </div> 
                    @foreach($product_attrs as $attr)
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3">{{$attr->attr->name}}:</label>
                            <div class="w-full mb-2">
                                <select class="select2 attrs" name="attr_{{$attr->attr->id}}[]" multiple="multiple" class="mb-3" data-selected="{{$attr->values}}">
                                    @foreach(json_decode($attr->attr->options) as $key => $value)
                                        <option value="{{$key}}" @if($attr->attr->type == 'color')title="{{$value->value}}"@endif>{{ $value->name }}</option>
                                    @endforeach                      
                                </select>                                                              
                            </div>
                        </div>                      
                    </div>                        
                    @endforeach
                    <div class="grid md:grid-cols-2 sm:grid-cols-1 my-2">
                        <div class="flex content-between items-center">
                            <label class="mr-5 w-1/3"></label>
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Lưu thay đổi
                            </button>
                        </div>                      
                    </div> 
                    </form>                       
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>

        </script>
    </x-slot>

</x-app-layout>
