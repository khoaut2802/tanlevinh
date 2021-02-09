<x-user-layout>
    <div class="my-2 row">
        <div class="col-12 col-sm-2">
            @include('user.navbar')
        </div>
        <div class="col-12 col-sm-10">
            <div class="card">
                <div class="card-header">Đổi mật khẩu</div>
                <div class="card-body">
                    @include('components.alert_bootstrap')
                    <div class="row">
                        <div class="col-12 col-sm-6">
                        <form method="POST" action="{{route('user.update.password')}}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Mật khẩu cũ:</label>
                                <input type="password" class="form-control" name="old_password">
                            </div>
                            <div class="form-group">
                                <label for="name">Mật khẩu mới:</label>
                                <input type="password" class="form-control" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="name">Nhập lại mật khẩu mới:</label>
                                <input type="password" class="form-control" name="new_password_confirmation">
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