<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;

use Hash;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $type = $request->get('type', '');
        $search = $request->get('search', '');
        
        $users = User::where('user_type', 'LIKE', "%{$type}%")->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->withCount('orders')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        
        // dd($products);
        return view('backend.users', compact('users'));
    }

    public function detail(Request $request, $id)
    {
        try {
            $user = User::find($id);

            return response()->json($user);
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $phone = $request->phone;
            $address = $request->address;
            $type = $request->user_type;


            if(User::where('email', $email)->exists())
                return redirect()->back()->withErrors('Người dùng đã tồn tại.');

            if(strlen($password) < 8)
                return redirect()->back()->withErrors('Mật khẩu phải có độ dài tối thiểu 8 ký tự.');

            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->password = Hash::make($password);
            $user->address = $address;
            $user->user_type = $type;

            if($request->has('patron'))
                $user->is_patron = 'yes';

            $user->created_at = Carbon::now();
            $user->save();
            
            return redirect()->back()->withSuccess('Thêm người dùng thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $phone = $request->phone;
            $address = $request->address;
            $type = $request->user_type;

            if(strlen($password) > 0 && strlen($password) < 8)
                return redirect()->back()->withErrors('Mật khẩu phải có độ dài tối thiểu 8 ký tự.');

            if($request->id == 1 && $type != 'admin')
                return redirect()->back()->withErrors('Bạn không thể thay đổi quyền cho người dùng này.');
                
            $user = User::find($request->id);
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;

            if(strlen($password) >= 8) {
                $user->password = Hash::make($password);
            }

            $user->address = $address;
            $user->user_type = $type;

            if($request->has('patron'))
                $user->is_patron = 'yes';

            $user->created_at = Carbon::now();
            $user->save();
            
            return redirect()->back()->withSuccess('Chỉnh sửa người dùng thành công');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try  {
            $user = User::where('id', $id)->first();

            if($user->user_type == 'admin' && User::where('user_type', 'admin')->count() == 1)
                return redirect()->back()->withErrors('Không thể xóa tài khoản Admin này.');

            $orders = Orders::where('user_id', $user->id)->get();
            foreach($orders as $order) {
                OrderDetails::where('order_id', $order->code)->delete();
            }

            Orders::where('user_id', $user->id)->delete();
            User::where('id', $id)->delete();

            return redirect()->back()->withSuccess('Xóa người dùng thành công.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
