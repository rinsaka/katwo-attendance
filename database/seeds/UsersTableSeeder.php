<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->delete();

    User::create([
      'name' => 'KatWO メンバー',
      'email' => 'a@sample.com',
      'login_id' => 'katwo',
      'password' => bcrypt(env('USER_PASSWORD')),
      'created_at' => Carbon::now()
    ]);
  }
}
