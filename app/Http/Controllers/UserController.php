<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Carbon\Carbon;

use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\Attributes;

use App\Mail\OrderNewMail;
use Mail;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $pending_orders = Orders::where('status', 'pending')->where('user_id', Auth::user()->id)->where('code', 'LIKE', "%OD%")->get();
        $processing_orders = Orders::where('status', 'processing')->where('user_id', Auth::user()->id)->where('code', 'LIKE', "%OD%")->get();
        $completed_orders = Orders::whereIn('status', ['completed','canceled'])->where('user_id', Auth::user()->id)->where('code', 'LIKE', "%OD%")->get();

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

            foreach($items as $item) {

                $order = new Orders;
                $order->code = time();
                $order->user_id = Auth::user()->id;
                $order->ship_method = 'bank';
                $order->status = 'pending';
                $order->created_at = Carbon::now();

                if($order->save()) {
                    $order->code = generateOrderCode($order->id);

                    if($order->save()) {
                        $details = [
                            'order_id'      => generateOrderCode($order->id),
                            'product_id'    => $item['product_id'],
                            'product_attrs' => json_encode($item['attrs']),
                            'quantity'      => $item['quantity'],
                            'price'         => $item['total_amount'],
                            'created_at'    => Carbon::now()
                        ];
                        OrderDetails::insert($details);
                        Mail::to('kd.tanlevinh@gmail.com')->send(new OrderNewMail($order));
                    }
                }
            }

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

    public function uploadFile(Request $request)
    {
        try {
            $id = $request->get('order_id');
            if ($request->hasFile('orderFile') && Orders::where('user_id', Auth::user()->id)->where('code', $id)->exists()) {
                if ($request->file('orderFile')->isValid()) {

                    $file_name = 'FILE'.time();
                    $extension = $request->orderFile->extension();
                    $request->file('orderFile')->storeAs('uploads/files/',$file_name.".".$extension, 'public');

                    $file = 'storage/uploads/files/'.$file_name.".".$extension;

                    Orders::where('code', $id)->update([
                        'file' => $file
                    ]);

                    return response()->json('Tải lên tệp thành công.', 200);
                } else {
                    return response()->json('Đã xảy ra lỗi!', 200);
                }
            }

            return response()->json('Đã xảy ra lỗi!', 200);
        } catch(\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function patrons(Request $request)
    {
        $orders = Orders::where('user_id', Auth::user()->id)->where('code', 'LIKE', '%IMP%')->get();
        return view('user.patrons', compact('orders'));
    }

    public function patronOrderView(Request $request)
    {
        $paper_types = json_decode(Attributes::where('name', 'Chất liệu')->first()->options);
        $paper_sizes = json_decode(Attributes::where('name', 'Kích thước')->first()->options);
        return view('user.patron', compact('paper_types', 'paper_sizes'));
    }

    public function patronOrder(Request $request)
    {
        try {
            $user = Auth::user();

            if($user->is_patron == 'no')
                return redirect()->route('user.dashboard');

            $code = 'IMP'.time();

            $order = new Orders;
            $order->code = $code;
            $order->user_id = $user->id;
            $order->ship_method = 'bank';
            $order->status = 'pending';
            $order->created_at = Carbon::now();
            if($order->save()) {
                $order->code = generateOrderCode($order->id, 'IMP');
                if($order->save()) {

                    $data = $request->all();
                    unset($data['_token']);
                    unset($data['compensate']);
                    unset($data['print_quantity']);
                    unset($data['cut']);
                    unset($data['quantity']);

                    $details[] = [
                        'order_id'      => generateOrderCode($order->id, 'IMP'),
                        'product_id'    => 0,
                        'product_attrs' => json_encode($data),
                        'quantity'      => $request->get('quantity'),
                        'cut'           => $request->get('cut'),
                        'compensate'    => $request->get('compensate'),
                        'print_quantity'=> $request->get('print_quantity'),
                        'price'         => 0,
                        'created_at'    => Carbon::now()
                    ];

                    OrderDetails::insert($details);
                    Mail::to('kd.tanlevinh@gmail.com')->send(new OrderNewMail($order));
                }
            }

            return redirect()->route('user.dashboard')->withSuccess('Đặt hàng thành công.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
