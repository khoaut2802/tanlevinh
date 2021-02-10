<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;
use Auth;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        
        $orders = Orders::where('status', 'LIKE', "%{$status}%")->where('code', 'LIKE', "%{$search}%")->with('user', 'detail', 'detail.product')->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();
        
        // dd($products);
        return view('backend.orders', compact('orders'));
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
}
