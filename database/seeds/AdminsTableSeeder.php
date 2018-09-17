<?php

use Illuminate\Database\Seeder;

use App\Admin;
use Carbon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('admins')->delete();

      Admin::create([
        'name' => 'Taro Admin',
        'email' => 'taro@sample.com',
        'login_id' => 'taro',
        'password' => bcrypt('admin'),
        'created_at' => Carbon::now()
      ]);

    }
}
