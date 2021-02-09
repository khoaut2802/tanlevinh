<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Carbon\Carbon;

use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pending_orders = Orders::where('status', 'pending')->with('detail', 'detail.product')->get();
        $processing_orders = Orders::where('status', 'processing')->with('detail', 'detail.product')->get();
        $completed_orders = Orders::where('status', 'completed')->orWhere('status', 'canceled')->with('detail', 'detail.product')->get();

        return view('user.dashboard', compact('pending_orders', 'processing_orders', 'completed_orders'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function password()
    {
        return view('user.password');
    }

    public function update(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            return redirect()->back()->withSuccess('Thay đổi thông tin thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            if(!Hash::check($request->old_password, Auth::user()->password)) {
                return redirect()->back()->withErrors('Mật khẩu cũ không chính xác.');
            } else if($request->new_password != $request->new_password_confirmation) {
                return redirect()->back()->withErrors('Mật khẩu mới và nhập lại mật khẩu phải giống nhau.');
            } else if(strlen($request->new_password) < 6) {
                return redirect()->back()->withErrors('Mật khẩu mới phải có tối thiểu 6 ký tự.');
            } else {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->new_password);
                $user->save();
                
                return redirect()->back()->withSuccess('Thay đổi thông tin thành công.');
            }   
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function createOrder(Request $request)
    {
        try {
            $items = $request->session()->get('cart');

            if(count($items) <= 0 || $items == null) {
                return redirect()->back();
            }

            $code = 'OD'.time();

            $order = new Orders;
            $order->code = $code;
            $order->user_id = Auth::user()->id;
            $order->ship_method = 'bank';
            $order->status = 'pending';
            $order->created_at = Carbon::now();
            $order->save();

            $details = [];
            foreach($items as $item) {
                $details[] = [
                    'order_id'      => $code,
                    'product_id'    => $item['product_id'],
                    'product_attrs' => json_encode($item['attrs']),
                    'quantity'      => $item['quantity'],
                    'price'         => $item['total_amount'] * $item['quantity'],
                    'created_at'    => Carbon::now()
                ];
            }

            OrderDetails::insert($details);

            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function detailOrder(Request $request, $code)
    {
        try {
            $check = Orders::where('code', $code)->where('user_id', Auth::user()->id)->exists();

            if(!$check)
                return abort(404);

            $order = Orders::where('code', $code)->first();

            return view('user.order', compact('order'));
        } catch(\Exception $e) {
            return abort(500);
        }
    }
    public function cancelOrder(Request $request)
    {
        try {
            $order_code = $request->get('order_code');

            $order = Orders::where('code', $order_code)->where('user_id', Auth::user()->id)->where('status', 'pending')->exists();

            if(!$order)
                return response()->json('Đã xảy ra lỗi', 400);

            Orders::where('code', $order_code)->update([
                'status'    => 'canceled'
            ]);

            return response()->json('Hủy đơn hàng thành công', 200);
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
