<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminGenerator::class,
            DefaultSettings::class,
            DefaultBanners::class,
            // DefaultMenus::class
            // DefaultPages::class
            DefaultHomeLayout::class,
            DefaultAttributes::class
        ]);
    }
}
