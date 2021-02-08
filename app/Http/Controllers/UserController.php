<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pending_orders = Orders::where('status', 'pending')->get();
        $processing_orders = Orders::where('status', 'processing')->get();
        $completed_orders = Orders::where('status', 'completed')->get();

        return view('user.dashboard', compact('pending_orders', 'processing_orders', 'completed_orders'));
    }
}
