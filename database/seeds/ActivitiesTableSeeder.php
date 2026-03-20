<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 一旦中身を削除する
      DB::table('activities')->delete();

      // 日付の取得
      $year = date('Y');
      $month = date('m');

      list ($prev_year, $prev_month) = $this->get_prev_month($year, $month);

      $acts = $this->mk_activities();
      $iter = 0;
      foreach ($acts as $act) {
        if($iter == 6) {
          DB::table('activities')->insert([
            'act_at' => $act,
            'place_id' => 2,
            'time_id' => 3,
            'note' => "運営会議",
            'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
            'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0)
          ]);
        } elseif ($iter == 9) {
          DB::table('activities')->insert([
            'act_at' => $act,
            'place_id' => 2,
            'time_id' => 3,
            'note' => "総会",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        } elseif ($iter == 16) {
          DB::table('activities')->insert([
            'act_at' => $act,
            'note' => "演奏会",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0)
          ]);
        } else {
          DB::table('activities')->insert([
            'act_at' => $act,
            'place_id' => 2,
            'time_id' => 3,
            'created_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0),
            'updated_at' => Carbon::create($prev_year, $prev_month, 20, 18, 0, 0)
          ]);
        }
        $iter++;
      }
    }

    /**
    *    活動の一覧を作成する
    *       今月 3回
    *       翌月 4回（4回目運営会議）
    *       翌々月 3回（3回目総会）
    *       3ヶ月先 3回
    *       4ヶ月先 3回
    *       8ヶ月先日曜 1回（本番）
    **/
    private function mk_activities()
    {
      $act_list = array(     // 月ごとの練習回数と曜日を指定
        ['count'=>3, 'w'=>6],
        ['count'=>4, 'w'=>6],
        ['count'=>3, 'w'=>6],
        ['count'=>3, 'w'=>6],
        ['count'=>3, 'w'=>6],
        ['count'=>0, 'w'=>6],
        ['count'=>0, 'w'=>6],
        ['count'=>0, 'w'=>6],
        ['count'=>1, 'w'=>0],
      );
      $year = date('Y');
      $month = date('m');
      $activities = array();
      $iter = 0;
      foreach($act_list as $act) {
        $m = $month + $iter;
        $tmp_acts = $this->get_activities($year, $m, $act['count'], $act['w']);
        if ($tmp_acts) {
          foreach($tmp_acts as $tmp_act) {
            $activities[] = $tmp_act;
          }
        }

        $iter++;
        if ($m == 12) {
          $year = $year + 1;
          $iter = 0;
          $month = 1;
        }

      }
      return $activities;
    }

    /**
    *    年と月を指定し，$count 回数だけ $w 曜日の日にちを返す．
    *
    *       $w : 0=>日，1=>月, ... 6=>土
    **/
    private function get_activities($year, $month, $count = 1, $w = 6)
    {
      if($count == 0) {
        return false;
      }
      $d = new DateTime();
      $d->setDate($year, $month, 1);
      $t = $d->format('t'); // 月末の日にちを取得
      $zm = sprintf('%02d', $month);

      $n_activities = 0;
      $activities = array();
      for ($i = 1; $i <= $t; $i++) {
        $zi = sprintf('%02d', $i);
        $date = date('w', strtotime($year.$zm.$zi));
        if ($date == $w) {
          $activities[] = $year.'-'.$zm.'-'.$zi;
          $n_activities++;
          if ($n_activities == $count) {
            break;
          }
        }
      }
      return $activities;
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
