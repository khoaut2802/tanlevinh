<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.orders', [
            'orders' => $this->month == 'all' ? Orders::all() : Orders::whereMonth('created_at', $this->month)->get()
        ]);
    }
}
