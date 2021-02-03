<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;
use Carbon\Carbon;

class DefaultMenus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'parent_id' => 0, 'name' => 'Danh thiếp', 'slug' => 'danh-thiep', 'created_at' => Carbon::now()],
            ['id' => 2, 'parent_id' => 1, 'name' => 'Danh thiếp tiêu chuẩn', 'slug' => 'danh-thiep-tieu-chuan', 'created_at' => Carbon::now()],
            ['id' => 3, 'parent_id' => 1, 'name' => 'Danh thiếp mỹ thuật', 'slug' => 'danh-thiep-my-thuat', 'created_at' => Carbon::now()],
            ['id' => 4, 'parent_id' => 1, 'name' => 'Danh thiếp cao cấp', 'slug' => 'danh-thiep-cao-cap', 'created_at' => Carbon::now()],
            ['id' => 5, 'parent_id' => 0, 'name' => 'Ấn phẩm văn phòng', 'slug' => 'an-pham-van-phong', 'created_at' => Carbon::now()],
            ['id' => 6, 'parent_id' => 5, 'name' => 'Giấy tiêu đề', 'slug' => 'giay-tieu-de', 'created_at' => Carbon::now()],
            ['id' => 7, 'parent_id' => 5, 'name' => 'Bao thư', 'slug' => 'bao-thu', 'created_at' => Carbon::now()],
            ['id' => 8, 'parent_id' => 5, 'name' => 'Bìa đựng hồ sơ', 'slug' => 'bia-dung-ho-so', 'created_at' => Carbon::now()]
        ];

        Menus::insert($data);
    }
}
