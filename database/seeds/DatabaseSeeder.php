<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
      $this->call(UsersTableSeeder::class);
      $this->call(AdminsTableSeeder::class);
      $this->call(PlacesTableSeeder::class);
      $this->call(TimesTableSeeder::class);
      $this->call(PartsTableSeeder::class);
      $this->call(ActivitiesTableSeeder::class);
      $this->call(MenusTableSeeder::class);
      $this->call(AttendancesTableSeeder::class);
  }
}
