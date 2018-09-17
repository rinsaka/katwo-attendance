<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 一旦中身を削除する
      DB::table('times')->delete();


      DB::table('times')->insert([
        'jikan' => '13:00 - 17:00',
        'default_jikan' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('times')->insert([
        'jikan' => '17:00 - 21:00',
        'default_jikan' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('times')->insert([
        'jikan' => '18:00 - 22:00',
        'default_jikan' => true,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('times')->insert([
        'jikan' => '13:00 - 22:00',
        'default_jikan' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

    }
}
