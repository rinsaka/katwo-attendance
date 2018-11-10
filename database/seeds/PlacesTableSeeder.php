<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 一旦中身を削除する
      DB::table('places')->delete();


      DB::table('places')->insert([
        'place' => '神戸常磐アリーナ 研修室A（スリッパ要）',
        'default_place' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('places')->insert([
        'place' => '神戸常磐アリーナ 研修室B',
        'default_place' => true,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('places')->insert([
        'place' => '神戸常磐アリーナ 会議室A',
        'default_place' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('places')->insert([
        'place' => '神戸常磐アリーナ 小ホール',
        'default_place' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('places')->insert([
        'place' => '西部市民会館（魚住）',
        'default_place' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('places')->insert([
        'place' => '瀬楽スタジオ',
        'default_place' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);


    }
}
