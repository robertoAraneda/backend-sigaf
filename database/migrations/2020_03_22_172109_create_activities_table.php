<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('activities', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('description', 255);
      $table->string('type', 100);
      $table->unsignedInteger('weighing')->default(10);
      $table->unsignedBigInteger('id_activity_moodle');
      $table->unsignedBigInteger('course_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('activities');
  }
}
