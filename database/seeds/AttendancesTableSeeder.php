<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

      // 日付の取得
      $year = date('Y');
      $month = date('m');

      list ($prev_year, $prev_month) = $this->get_prev_month($year, $month);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 7,
        'attendance' => 3,
        'comment' => "短いコメント",
        'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 10, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 8,
        'attendance' => 1,
        'comment' => "長いコメントは途中まで表示されます．長いコメントは途中まで表示されます．",
        'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 10, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 9,
        'attendance' => 1,
        'comment' => "あいうえお",
        'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'たろー',
        'part_id' => 2,
        'activity_id' => 10,
        'attendance' => 3,
        'comment' => "コメント",
        'comment' => "あいうえおか",
        'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 7,
        'attendance' => 3,
        'comment' => "あいうえおかき",
        'created_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 8,
        'attendance' => 3,
        'comment' => "あいうえおかきく",
        'created_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 9,
        'attendance' => 3,
        'comment' => "これもコメント",
        'created_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0)
      ]);

      DB::table('attendances')->insert([
        'name' => 'ジロー',
        'part_id' => 3,
        'activity_id' => 10,
        'attendance' => 1,
        'created_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0),
        'updated_at' => Carbon::create($prev_year, $prev_month, 11, 18, 0, 0)
      ]);

    }

    /**
    *     前の月を取得する
    *
    *
    **/
    private function get_prev_month($year, $month)
    {
      $n_year = (int)$year;
      $n_month = (int)$month;

      if ($n_month == 1) {
        $n_year--;
        $n_month = 12;
      } else {
        $n_month--;
      }
      $year = sprintf("%04d", $n_year);
      $month = sprintf("%02d", $n_month);
      return array($year, $month);
    }
}
