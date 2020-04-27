<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityCourseUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('activity_course_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('activity_id');
      $table->unsignedBigInteger('course_registered_user_id');
      $table->string('status_moodle');
      $table->string('qualification_moodle');
      $table->timestamps();

      $table->foreign('activity_id')->references('id')->on('activities');
      $table->foreign('course_registered_user_id')->references('id')->on('course_registered_users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('activity_course_users');
  }
}
