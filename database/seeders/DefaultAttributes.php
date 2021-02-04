<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attributes;
use Carbon\Carbon;

class DefaultAttributes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Kích thước', 'type' => 'select', 'options' => json_encode(['name' => '10 x 10cm', 'price' => '0']), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Chất liệu', 'type' => 'card', 'options' => json_encode([['name' => 'Couche 150 gsm', 'price' => 0], ['name' => 'Couche 150 gsm', 'price' => 0], ['name' => 'Fort 100 gsm', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Màu sắc', 'type' => 'color', 'options' => json_encode(['#333333', '#ffffff']), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Số mặt', 'type' => 'card', 'options' => json_encode([['name' => '1 Mặt', 'price' => 0], ['name' => '2 Mặt', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Loại màng', 'type' => 'card', 'options' => json_encode([['name' => 'Cán màng mờ 1 mặt', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Kiểu bế', 'type' => 'card', 'options' => json_encode([['name' => 'Bo 4 góc mẫu 4', 'price' => 0], ['name' => 'Bo 4 góc mẫu 5', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Đục lỗ', 'type' => 'card', 'options' => json_encode([['name' => 'Có', 'price' => 0], ['name' => 'Không', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Thời gian', 'type' => 'card', 'options' => json_encode([['name' => '1 ngày', 'price' => 0], ['name' => '3 ngày', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Số lượng', 'type' => 'card', 'options' => json_encode([['name' => '1 lốc', 'price' => 0], ['name' => '2 lốc', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Dán', 'type' => 'select', 'options' => json_encode([['name' => 'Không', 'price' => 0], ['name' => 'Nắp dán keo', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()],
            ['name' => 'Duyệt mẫu', 'type' => 'select', 'options' => json_encode([['name' => 'Không', 'price' => 0], ['name' => 'Có', 'price' => 0]]), 'status' => 'enabled', 'created_at' => Carbon::now()]
        ];

        Attributes::insert($data);
    }
}
