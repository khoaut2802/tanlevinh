<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 20);
        $from = $request->get('from', Carbon::now()->firstOfMonth());
        $to = $request->get('to', Carbon::now()->lastOfMonth());
        
        $orders = Orders::where('status', 'completed')->whereBetween('created_at',[Carbon::parse($from), Carbon::parse($to)])
        ->orderBy('id','DESC')
        ->paginate($per_page, $columns = ['*'], $pageName = 'page', $page)->toArray();

        return view('backend.dashboard', compact('orders'));
    }
}
