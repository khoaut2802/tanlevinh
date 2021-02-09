<x-user-layout>
    <div class="my-2 row">
        <div class="col-12 col-sm-2">
            @include('user.navbar')
        </div>
        <div class="col-12 col-sm-10">
            <div class="card">
                <div class="card-header">Thông tin tài khoản</div>
                <div class="card-body">
                    @include('components.alert_bootstrap')
                    <div class="row">
                        <div class="col-12 col-sm-6">
                        <form method="POST" action="{{route('user.update')}}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên của bạn:</label>
                                <input class="form-control" name="name" value="{{Auth::user()->name}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Địa chỉ Email:</label>
                                <input class="form-control disabled" value="{{Auth::user()->email}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Số điện thoại:</label>
                                <input class="form-control" name="phone" value="{{Auth::user()->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Địa chỉ:</label>
                                <input class="form-control" name="address" value="{{Auth::user()->address}}">
                            </div> 
                            <div class="form-group">
                                <label for="name">Ngày tham gia:</label>
                                <input class="form-control disabled" value="{{\Carbon\Carbon::parse(Auth::user()->created_at)->format('d-m-Y')}}" readonly>
                            </div> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Thay đổi</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>