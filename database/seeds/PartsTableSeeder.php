<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 一旦中身を削除する
      DB::table('parts')->delete();


      DB::table('parts')->insert([
        'part' => 'Flute and Oboe',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Clarinet',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Saxophone',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Horn',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Euphonium',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Tuba',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Trumpet',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Trombone',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Percussion',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);
    }
}
