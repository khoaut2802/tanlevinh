<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pages;

class DefaultPages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['menu_id' => 1, 'title' => 'Danh thiếp', 'content' => 'Demo danh thiếp', 'status' => 'enable'],
            ['menu_id' => 2, 'title' => 'Danh thiếp tiêu chuẩn', 'content' => 'Demo danh thiếp', 'status' => 'enable'],
            ['menu_id' => 3, 'title' => 'Danh thiếp mỹ thuật', 'content' => 'Demo danh thiếp', 'status' => 'enable'],
            ['menu_id' => 4, 'title' => 'Danh thiếp cao cấp', 'content' => 'Demo danh thiếp', 'status' => 'enable'],
            ['menu_id' => 5, 'title' => 'Ấn phẩm văn phòng', 'content' => 'Demo n phẩm văn phòng', 'status' => 'enable'],
            ['menu_id' => 5, 'title' => 'Giấy tiêu đề', 'content' => 'Demo Giấy tiêu đề', 'status' => 'enable'],
            ['menu_id' => 5, 'title' => 'Bao thư', 'content' => 'Demo Bao thư', 'status' => 'enable'],
            ['menu_id' => 5, 'title' => 'Bìa đựng hồ sơ', 'content' => 'Demo Bìa đựng hồ sơ', 'status' => 'enable']
        ];

        Pages::insert($data);
    }
}
