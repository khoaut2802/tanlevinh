<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;
use App\Models\Attributes;
use App\Models\OrderDetails;
use Auth;
use Carbon\Carbon;
use DB;
use App\Models\User;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 20);
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        $user = Auth::user();
        
        if($user->user_type == 'admin') {
            if($search != '') {
                $orders = Orders::where('status', 'LIKE', "%{$status}%")
                ->where('code', 'LIKE', "%{$search}%")->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
                // dd($orders);
                if(empty($orders['data'])) {
                    $user = User::where('email', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->first();

                    if(!empty($user)) {
                        $orders = Orders::where('user_id', $user->id)->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
                    } else {
                        $orders = Orders::where('user_id', 'empty')->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();         
                    }
                }
            } else {
                $orders = Orders::where('status', 'LIKE', "%{$status}%")
                ->where('code', 'LIKE', "%{$search}%")
                ->with(['user' => function($query) use ($search) {
                    if($search != '') {
                        $query->where([['email', 'LIKE', "%{$search}%"], ['name', 'LIKE', "%{$search}%"]]);
                    }

                    return $query;
                }, 'detail', 'detail.product'])->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
            }
        } else {
            if($search != '') {
                $orders = Orders::where('print_machine', $user->print_machine ?? 'Unknown')->where('status', 'LIKE', "%{$status}%")
                ->where('code', 'LIKE', "%{$search}%")->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
                // dd($orders);
                if(empty($orders['data'])) {
                    $user = User::where('email', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->first();

                    if(!empty($user)) {
                        $orders = Orders::where('print_machine', $user->print_machine ?? 'Unknown')->where('user_id', $user->id)->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
                    } else {
                        $orders = Orders::where('print_machine', $user->print_machine ?? 'Unknown')->where('user_id', 'empty')->with('user', 'detail', 'detail.product')->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();         
                    }
                }
            } else {
                $orders = Orders::where('print_machine', $user->print_machine ?? 'Unknown')->where('status', 'LIKE', "%{$status}%")
                ->where('code', 'LIKE', "%{$search}%")
                ->with(['user' => function($query) use ($search) {
                    if($search != '') {
                        $query->where([['email', 'LIKE', "%{$search}%"], ['name', 'LIKE', "%{$search}%"]]);
                    }

                    return $query;
                }, 'detail', 'detail.product'])->orderBy('id','DESC')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
            }      
        }
        
        $paper_types = json_decode(Attributes::where('name', 'Chất liệu')->first()->options);
        $paper_sizes = json_decode(Attributes::where('name', 'Kích thước')->first()->options);        
        // dd($products);
        return view('backend.orders', compact('orders', 'paper_types', 'paper_sizes'));
    }


    public function detail(Request $request, $id)
    {
        $checkOrder = Orders::where('code', $id)->exists();
        if(!$checkOrder) {
            return response()->json('Không tìm thấy đơn hàng.', 400);
        }

        $order = Orders::where('code', $id)->first();
        
        return view('backend.order_detail', compact('order'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $action = $request->action;
        $send_mail = $request->send_mail;

        $checkOrder = Orders::where('code', $id)->exists();
        if(!$checkOrder) {
            return response()->json('Không tìm thấy đơn hàng.', 400);
        }

        Orders::where('code', $id)->update([
            'status' => $action
        ]);

        $order = Orders::where('code', $id)->first();
        
        if($send_mail == 'yes')
            Mail::to($order->user->email)->send(new OrderStatusMail($order));

        return response()->json('Chuyển đổi trạng thái đơn hàng thành công.');
    }

    public function print($code)
    {
        $order = Orders::where('code', $code)->first();

        if(!$order)
            return redirect()->back()->withErrors('Đơn hàng không tồn tại.');

        return view('backend.print', compact('order'));
    }

    public function updateMachine(Request $request, $id)
    {
        $update = Orders::find($id)->update($request->only(['print_machine']));

        if($update) return redirect()->back()->withSuccess('Cập nhật máy sản xuất thành công.');

        return redirect()->back()->withError('Đã xảy ra lỗi.');
    }

    public function store(Request $request)
    {
        try {
            // dd(getCartAttrs($request->all()));
            $code = 'OD'.time();

            $details = [
                'order_id'      => $code,
                'product_id'    => $request->product,
                'product_attrs' => json_encode(getCartAttrs($request->all())),
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'created_at'    => Carbon::now()
            ];
            
            if(OrderDetails::insert($details)) {
                $order = new Orders;
                $order->code = $code;
                $order->user_id = $request->user_id;
                $order->ship_method = 'bank';
                $order->status = $request->status;
                $order->created_at = Carbon::now();
                $order->note = $request->note ?? null;
                $order->print_machine = $request->print_machine ?? null;
                $order->save();
            }           

            return redirect()->route('orders')->withSuccess('Tạo đơn hàng thành công.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function show(Request $request, $code = null)
    {
        try {
            $action = $request->action;
            $order = null;
            $form_url = route('orders.create');

            if($code) {
                $form_url = route('orders.update.v2', ['code' => $code]);
                $order = Orders::where('code', $code)->first();

                if(!$order)
                    return 'Không tìm thấy đơn hàng';
            }

            $paper_types = json_decode(Attributes::where('name', 'Chất liệu')->first()->options);
            $paper_sizes = json_decode(Attributes::where('name', 'Kích thước')->first()->options);      

            return view('components.order_edit_modal', compact('order', 'paper_types', 'paper_sizes', 'action', 'form_url'));
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateV2(Request $request, $code)
    {
        try {
            $order = Orders::where('code', $code)->first();
            $order->user_id = $request->user_id;
            $order->print_machine = $request->print_machine;
            $order->note = $request->note ?? null;
            $order->status = $request->status ?? 'pending';
            
            if($order->save()) {
                if($order->detail[0]->product_id == 0) {
                    $data = $request->only(['paper_type', 'paper_size', 'name', 'print_size', 'zinc_quantity', 'color', 'quantity', 'compensate', 'cut', 'note']);
                } else {
                    $data = getCartAttrs($request->all());
                }
                
                $details = [
                    'product_id'    => $request->product ?? 0,
                    'product_attrs' => json_encode($data),
                    'quantity'      => $request->quantity ?? 1,
                    'price'         => (float)$request->price,
                    'created_at'    => Carbon::now()
                ];

                OrderDetails::where('order_id', $code)->update($details);
            }

            return redirect()->route('orders')->withSuccess('Cập nhật đơn hàng thành công.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }    
}
