<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('menus', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('activity_id')->unsigned();
      $table->string('name', 30);  // sqlite では文字列の長さは指定しても意味がない
      $table->string('menu')->nullable();
      $table->timestamps();

      $table->foreign('activity_id')
              ->references('id')
              ->on('activities')
              ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('menus');
  }
}
