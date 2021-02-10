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
                                    <label for="paper_type">Loại giấy:</label>
                                    <input class="form-control" name="paper_type" placeholder="VD: F250" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="paper_size">Khổ giấy:</label>
                                    <input class="form-control" name="paper_size" placeholder="VD: 79 x 109" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="quantity">Số lượng:</label>
                                    <input class="form-control" name="quantity" type="number" placeholder="VD: 100" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="print_size">Khổ in:</label>
                                    <input class="form-control" name="print_size" placeholder="VD: 54 x 79" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="print_quantity">Số lượng in:</label>
                                    <input class="form-control" name="print_quantity" placeholder="VD: 150" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="compensate">Bù hao:</label>
                                    <input class="form-control" name="compensate" placeholder="VD: 50" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="zinc_quantity">Số kẽm:</label>
                                    <input class="form-control" name="zinc_quantity" placeholder="VD: 4" required>
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
                                    <label for="cut">Cắt:</label>
                                    <input class="form-control" name="cut" placeholder="VD: 2" required>
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
</x-user-layout>