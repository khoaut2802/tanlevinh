<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeLayouts;
use Carbon\Carbon;

class DefaultHomeLayout extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['menu_id' => 1, 'name' => 'first', 'order' => 0, 'created_at' => Carbon::now()],
            ['menu_id' => 5, 'name' => 'second', 'order' => 1, 'created_at' => Carbon::now()]
        ];

        HomeLayouts::insert($data);
    }
}
