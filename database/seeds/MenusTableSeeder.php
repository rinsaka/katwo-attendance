<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenusTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // 一旦中身を削除する
    DB::table('menus')->delete();

    // 日付の取得
    $year = date('Y');
    $month = date('m');

    list ($prev_year, $prev_month) = $this->get_prev_month($year, $month);

    DB::table('menus')->insert([
      'activity_id' => 1,
      'name' => 'たろー',
      'menu' => "19時から 合奏 ・ピアノコンチェルト・交響曲第1番",
      'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
      'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 10, 0)
    ]);

    DB::table('menus')->insert([
      'activity_id' => 2,
      'name' => 'たろー',
      'menu' => "19時から 合奏 ・交響曲第2番",
      'created_at' => Carbon::create($prev_year, $prev_month, 22, 20, 0, 0),
      'updated_at' => Carbon::create($prev_year, $prev_month, 22, 20, 0, 0)
    ]);

    DB::table('menus')->insert([
      'activity_id' => 3,
      'name' => 'じろー',
      'menu' => "19時から 合奏 ・交響曲第3番",
      'created_at' => Carbon::create($prev_year, $prev_month, 23, 20, 0, 0),
      'updated_at' => Carbon::create($prev_year, $prev_month, 23, 20, 0, 0)
    ]);

    DB::table('menus')->insert([
      'activity_id' => 4,
      'name' => 'たろー',
      'menu' => "19時から 合奏 ・交響曲第4番・ピアノコンチェルト",
      'created_at' => Carbon::yesterday(),
      'updated_at' => Carbon::yesterday()
    ]);
    DB::table('menus')->insert([
      'activity_id' => 6,
      'name' => 'たろー',
      'menu' => "19時から 合奏 ・ピアノコンチェルト",
      'created_at' => Carbon::yesterday(),
      'updated_at' => Carbon::now()
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
