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

      DB::table('activities')->insert([
        'act_at' => '2018-08-04',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-08-18',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-08-25',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-09-01',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-09-08',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);


      DB::table('activities')->insert([
        'act_at' => '2018-09-15',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-09-29',
        'place_id' => 2,
        'time_id' => 3,
        'note' => "運営会議",
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);


      DB::table('activities')->insert([
        'act_at' => '2018-10-06',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-10-20',
        'place_id' => 2,
        'time_id' => 3,
        'note' => '総会',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-10-27',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-11-10',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-11-17',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-11-24',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-12-01',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);


      DB::table('activities')->insert([
        'act_at' => '2018-12-08',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2018-12-15',
        'place_id' => 2,
        'time_id' => 3,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('activities')->insert([
        'act_at' => '2019-07-14',
        'place_id' => null,
        'time_id' => null,
        'note' => '本番',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);
    }
}
