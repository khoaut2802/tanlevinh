<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Hash;

class AdminGenerator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@tanlevinh.vn';
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('123456');
        $user->created_at = Carbon::now();
        $user->save();
    }
}
