<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orders;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        switch($this->order->status) {
            case 'completed':
                $status = '<span style="color: red"><b>Đã hoàn tất</b></span>';
            break;
            case 'processing':
                $status = '<span style="color: red"><b>Đang xử lý</b></span>';
            break;   
            default:
                $status = '<span style="color: red"><b>Hủy bỏ</b></span>';
        }

        return $this->markdown('vendor.notifications.order_status')->with([
            'order_code' => $this->order->code,
            'order_status' => $status
        ])->subject('Thông báo đơn hàng số #'.$this->order->code);
    }
}
