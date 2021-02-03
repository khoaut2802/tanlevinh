<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banners;

class DefaultBanners extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Công ty TNHH TM-DV Tân Lê Vinh', 'position' => 'top', 'image' => 'banners/top-default.jpg', 'link' => 'http://localhost/'],
            ['name' => 'Công ty TNHH TM-DV Tân Lê Vinh', 'position' => 'main', 'image' => 'banners/main-default.jpg', 'link' => 'http://localhost/'],
        ];

        Banners::insert($data);
    }
}
