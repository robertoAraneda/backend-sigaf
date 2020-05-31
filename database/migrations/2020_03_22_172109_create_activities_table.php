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
      $table->string('type', 25);
      $table->unsignedBigInteger('section_id');
      $table->unsignedInteger('weighing')->default(10);
      $table->unsignedBigInteger('id_activity_moodle');
      $table->unsignedBigInteger('course_id');
      $table->timestamps();

      $table->foreign('course_id')->references('id')->on('courses');
      $table->foreign('section_id')->references('id')->on('sections');
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
