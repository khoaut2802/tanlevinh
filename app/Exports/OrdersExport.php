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
            $total = 0;
            $orders = $orders->map(function($item) use ($total) {
                $ar = [];
                $ar['id'] = $item->id;
                $ar['code'] = $item->code;
                $ar['user'] = $item->user->name;

                $product_detail = json_decode($item->detail[0]->product_attrs, true);

                if($item->detail[0]->product_id != 0) {
                    $ar['product_name'] = $item->detail[0]->product->name;
                    $ar['paper_type'] = $product_detail ? (isset($product_detail[0]) ? $product_detail[0]['values']['name'] : 'Không') : 'Không';
                    $ar['paper_size'] = $product_detail ? (isset($product_detail[1]) ? $product_detail[1]['values']['name'] : 'Không') : 'Không';
                } else {
                    $ar['product_name'] = $product_detail['name'] ?? '';
                    $ar['paper_type'] = $product_detai['paper_type'] ?? 'Không';
                    $ar['paper_size'] = $product_detai['paper_size'] ?? 'Không';
                }

                $ar['quantity'] = $item->detail[0]->quantity ?? 0;
                $ar['print_quantity'] = $item->detail[0]->print_quantity ?? 0;
                $ar['compensate'] = $item->detail[0]->compensate ?? 0;
                $ar['cut'] = $item->detail[0]->cut ?? 0;
                $ar['print_machine'] = $item->print_machine ?? 'Không';
                $ar['price'] = $item->detail[0]->price ?? 0;
                $ar['created_at'] = formatDate($item->created_at);
                $ar['note'] = $item->note;
                $ar['staff'] = $item->user ? $item->user->name : 'Không';
                $ar['status'] = strip_tags(formatStatus($item->status));
                $total += $item->detail[0]->price ?? 0;
                return $ar;
            })->toArray();

            $new_ar = ['','Tổng đơn:', count($orders), 'Tổng tiền:', $total];

            return collect(array_merge($orders, $new_ar));
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
