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
        'name' => 'KatWO 役員',
        'email' => 'y@sample.com',
        'login_id' => 'yakuin',
        'password' => bcrypt(env('ADMIN_PASSWORD')),
        'created_at' => Carbon::now()
      ]);

    }
}
