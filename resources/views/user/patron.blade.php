<x-user-layout>
    <div class="my-2 row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Đặt hàng</div>
                <div class="card-body">
                    @include('components.alert_bootstrap')
                    <form method="POST" action="{{route('user.patron.order')}}">
                    @csrf
                    <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nhập tên sản phẩm:</label>
                                    <input class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="paper_type">Loại giấy:</label>
                                    <select class="form-control tags" name="paper_type" required>
                                        @foreach($paper_types as $type)
                                            <option value="{{$type->name}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="paper_size">Khổ giấy:</label>
                                    <select class="form-control tags" name="paper_size" required>
                                        @foreach($paper_sizes as $size)
                                            <option value="{{$size->name}}">{{$size->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="print_size">Khổ in:</label>
                                    <select class="form-control tags" name="print_size" required>
                                        <option value="54 x 79cm">54 x 79cm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="zinc_quantity">Số kẽm:</label>
                                    <select class="form-control tags" name="zinc_quantity" required>
                                        @for($i = 1; $i <= 20; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="color">Màu sắc:</label>
                                    <input class="form-control" name="color" placeholder="VD: CMYK" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="quantity">Số lượng:</label>
                                    <input class="form-control" name="quantity" type="number" value="10" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="compensate">Bù hao:</label>
                                    <input class="form-control" name="compensate" type="number" value="5" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="cut">Cắt:</label>
                                    <input class="form-control" name="cut" type="number" value="2" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="print_quantity">Số lượng in = (Số lượng * Cắt - Bù hao)</label>
                                    <input type="number" class="form-control" name="print_quantity" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Đặt hàng</button>
                            </div>
                            </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $('.tags').select2({
                placeholder: "Chọn giá trị hoặc nhập giá trị mới",
                tags: true
            })

            refreshPrintQuantity()

            $('input[name="quantity"]').on('input', function() {
                refreshPrintQuantity();
            })

            $('input[name="cut"]').on('input', function() {
                refreshPrintQuantity();
            })

            $('input[name="compensate"]').on('input', function() {
                refreshPrintQuantity();
            })

            function refreshPrintQuantity() {
                var quantity = parseInt($('input[name="quantity"]').val()) || 0;
                var cut = parseInt($('input[name="cut"]').val()) || 0;
                var compensate = parseInt($('input[name="compensate"]').val()) || 0;

                var total = (quantity * cut) - compensate;

                $('input[name="print_quantity"]').val(total);
            }
        </script>
    </x-slot>
</x-user-layout>
