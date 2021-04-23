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
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 20);
        $status = $request->get('status', null);
        $search = $request->get('search', null);
        $month = $request->get('month', 'all');
        $user = Auth::user();

        $orders = new Orders;

        if($status) {
            $orders = $orders->where('status', $status);
        }

        if($month != 'all') {
            $orders = $orders->whereMonth('created_at', $month);
        }

        if($search) {
            $orders = $orders->orWhere('code', 'LIKE', '%'.$search.'%')->with(['user', 'detail', 'detail.product', 'staff'])->has('detail');
        } else {
            $orders = $orders->with(['user', 'detail', 'detail.product', 'staff'])->has('detail');
        }

        if($search && !$orders->exists()) {
            $orders = new Orders;

            if($status) {
                $orders = $orders->where('status', $status);
            }

            if($month != 'all') {
                $orders = $orders->whereMonth('created_at', $month);
            }

            $orders = $orders->with(['user', 'detail', 'detail.product', 'staff'])->has('detail');

            $orders = $orders->orderBy('id', 'DESC')->paginate($per_page, ['*'], 'page', $page)->map(function ($item) use ($search) {
                if($search && strpos($item->user->email, $search) !== false || strpos($item->user->name, $search) !== false) {
                    return $item;
                }
            })->toArray();
        } else {
            $orders = $orders->orderBy('id', 'DESC')->paginate($per_page, ['*'], 'page', $page)->map(function ($item) use ($search) {
                return $item;
            })->toArray();
        }

        $orders = array_filter($orders);
        $orders = $this->paginate($orders, $per_page, $page)->toArray();

        $paper_types = json_decode(Attributes::where('name', 'Chất liệu')->first()->options);
        $paper_sizes = json_decode(Attributes::where('name', 'Kích thước')->first()->options);
        // dd($products);
        return view('backend.orders', compact('orders', 'paper_types', 'paper_sizes'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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

    public function updateMachine(Request $request, $id = null)
    {
        if(!$id) $id = $request->id;

        $update = Orders::find($id)->update($request->only(['print_machine']));

        if($update) return redirect()->back()->withSuccess('Cập nhật máy sản xuất thành công.');

        return redirect()->back()->withErrors('Đã xảy ra lỗi.');
    }

    public function store(Request $request)
    {
        try {
            // dd(getCartAttrs($request->all()));

            $order = new Orders;
            $order->code = 'empty';
            $order->user_id = $request->user_id;
            $order->ship_method = 'bank';
            $order->status = $request->status;
            $order->created_at = Carbon::now();
            $order->note = $request->note ?? null;

            if($order->save()) {
                $order->code = generateOrderCode($order->id);
                if($order->save()) {
                    $details = [
                        'order_id'      => generateOrderCode($order->id),
                        'product_id'    => $request->product,
                        'product_attrs' => json_encode(getCartAttrs($request->all())),
                        'quantity'      => $request->quantity,
                        'price'         => $request->price,
                        'cut'           => $request->cut,
                        'compensate'    => $request->compensate,
                        'print_quantity'=> $request->print_quantity,
                        'created_at'    => Carbon::now()
                    ];

                    OrderDetails::insert($details);
                }
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
                    'compensate'         => (float)$request->compensate,
                    'cut'         => (float)$request->cut,
                    'print_quantity'         => (float)$request->print_quantity,
                    'created_at'    => Carbon::now()
                ];

                OrderDetails::where('order_id', $code)->update($details);
            }

            return redirect()->route('orders')->withSuccess('Cập nhật đơn hàng thành công.');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function staffUpdate(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        Orders::where('id', $id)->update(['status' => $status]);

        return redirect()->back()->withSuccess('Thay đổi trạng thái đơn hàng thành công');
    }

    public function export(Request $request)
    {
        $month = $request->get('month', 'all');

        return Excel::download(new OrdersExport($month), 'orders.xlsx');
    }
}
