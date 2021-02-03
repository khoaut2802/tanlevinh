<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class DefaultSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'company_name', 'value' => 'CTY TNHH TM-DV Quảng Cáo Tân Lê Vinh'],
            ['key' => 'company_address', 'value' => '	16 Đường Số 9, Phường 16, Quận Gò Vấp, TP.Hồ Chí Minh'],
            ['key' => 'company_email', 'value' => 'tanlevinh@gmail.com'],
            ['key' => 'company_phone', 'value' => '(84.8) 2219 8396'],
            ['key' => 'company_business_time', 'value' => 'Thứ 2 đến thứ 7 hàng tuần, từ 8h - 17h'],
            ['key' => 'maintenance','value' => false],
            ['key' => 'enable_register', 'value' => false],
            ['key' => 'enable_top_banner', 'value' => true],
            ['key' => 'enable_main_banner', 'value' => true],
        ];

        Settings::insert($data);
    }
}
