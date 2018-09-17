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
        'created_at' => '2018-08-10 17:00:00',
        'updated_at' => '2018-08-10 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 8,
        'attendance' => 2,
        'created_at' => '2018-08-10 17:00:00',
        'updated_at' => '2018-08-10 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 9,
        'attendance' => 1,
        'created_at' => '2018-08-10 17:00:00',
        'updated_at' => '2018-08-10 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 10,
        'attendance' => 3,
        'comment' => "コメント",
        'created_at' => '2018-08-10 17:00:00',
        'updated_at' => '2018-08-10 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 7,
        'attendance' => 3,
        'created_at' => '2018-08-11 17:00:00',
        'updated_at' => '2018-08-11 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 8,
        'attendance' => 3,
        'created_at' => '2018-08-11 17:00:00',
        'updated_at' => '2018-08-11 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 9,
        'attendance' => 3,
        'comment' => "これもコメント",
        'created_at' => '2018-08-11 17:00:00',
        'updated_at' => '2018-08-11 17:00:00'
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 10,
        'attendance' => 3,
        'created_at' => '2018-08-11 17:00:00',
        'updated_at' => '2018-08-11 17:00:00'
      ]);

    }
}
