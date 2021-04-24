<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Writer;
use Maatwebsite\Excel\Excel;



class OrdersExport implements FromCollection, ShouldAutoSize, WithEvents
{
    protected $month;
    protected $calledByEvent;

    public function __construct($month)
    {
        $this->month = $month;
        $this->calledByEvent = false;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->calledByEvent) { // flag
            $orders = $this->month == 'all' ? Orders::with('detail', 'detail.product', 'user', 'staff')->has('detail')->get() : Orders::whereMonth('created_at', $this->month)->with('detail', 'detail.product', 'user', 'staff')->has('detail')->get();

            $orders = $orders->map(function($item) {
                $ar = [];
                $ar['id'] = $item->id;
                $ar['code'] = $item->code;
                $ar['user'] = $item->user->name;

                $product_detail = json_decode($item->detail[0]->product_attrs, true);

                if($item->detail[0]->product_id != 0) {
                    $ar['product_name'] = $item->detail[0]->product->name;
                } else {
                    $ar['product_name'] = $product_detail['name'] ?? '';
                }

                $ar['print_machine'] = $item->print_machine;
                $ar['quantity'] = $item->detail[0]->quantity;
                $ar['price'] = $item->detail[0]->price;
                $ar['created_at'] = formatDate($item->created_at);
                $ar['note'] = $item->note;
                $ar['staff'] = $item->user ? $item->user->name : 'Không';
                $ar['status'] = $item->status;

                return $ar;
            });

            return $orders;
        }

        return collect([]);
        // return view('exports.orders', [
        //     'orders' =>
        // ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function(BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(public_path('tanlevinh.xlsx'));
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->getSheetByIndex(0);

                $this->calledByEvent = true; // set the flag
                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }
}
