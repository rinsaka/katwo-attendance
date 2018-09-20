<?php

use Illuminate\Database\Seeder;


class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 一旦中身を削除する
      DB::table('attendances')->delete();

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 7,
        'attendance' => 3,
        'comment' => "短いコメント",
        'created_at' => '2018-09-10 18:00:00',
        'updated_at' => '2018-09-10 18:10:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 8,
        'attendance' => 2,
        'comment' => "長いコメントは途中まで表示されます．長いコメントは途中まで表示されます．",
        'created_at' => '2018-09-20 18:00:00',
        'updated_at' => '2018-09-20 18:10:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 9,
        'attendance' => 1,
        'comment' => "あいうえお",
        'created_at' => '2018-09-20 18:00:00',
        'updated_at' => '2018-09-20 18:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 10,
        'attendance' => 3,
        'comment' => "コメント",
        'comment' => "あいうえおか",
        'created_at' => '2018-09-20 18:00:00',
        'updated_at' => '2018-09-20 18:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 7,
        'attendance' => 3,
        'comment' => "あいうえおかき",
        'created_at' => '2018-08-11 18:00:00',
        'updated_at' => '2018-08-11 18:00:03'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 8,
        'attendance' => 3,
        'comment' => "あいうえおかきく",
        'created_at' => '2018-08-11 18:00:00',
        'updated_at' => '2018-08-11 18:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 9,
        'attendance' => 3,
        'comment' => "これもコメント",
        'created_at' => '2018-08-11 18:00:00',
        'updated_at' => '2018-08-11 18:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 10,
        'attendance' => 3,
        'created_at' => '2018-08-11 18:00:00',
        'updated_at' => '2018-08-11 18:00:00'
      ]);

    }
}
