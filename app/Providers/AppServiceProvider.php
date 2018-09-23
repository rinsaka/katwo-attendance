<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;  //  <<<<---- 追加

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // sqlite のときだけ外部キー制約を有効にする
      if (\DB::getDriverName() == 'sqlite') {
        DB::statement('PRAGMA foreign_keys=ON');
      }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
