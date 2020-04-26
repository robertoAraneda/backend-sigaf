<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('description', 100);
      $table->unsignedBigInteger('platform_id');
      $table->unsignedBigInteger('id_category_moodle');
      $table->unsignedInteger('status')->default(1);
      $table->timestamps();

      $table->foreign('platform_id')->references('id')->on('platforms');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('categories');
  }
}
