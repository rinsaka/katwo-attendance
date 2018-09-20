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
        's_part' => 'Fl/Ob',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Clarinet',
        's_part' => 'Cl',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Saxophone',
        's_part' => 'Sax',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Horn',
        's_part' => 'Hr',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Euphonium',
        's_part' => 'Euph',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Tuba',
        's_part' => 'Tub',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Trumpet',
        's_part' => 'Trp',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Trombone',
        's_part' => 'Trb',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);

      DB::table('parts')->insert([
        'part' => 'Percussion',
        's_part' => 'Perc',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);
    }
}
