<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityCourseRegisteredUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('activity_course_registered_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('activity_id');
      $table->unsignedBigInteger('course_registered_user_id');
      $table->string('status_moodle');
      $table->string('qualification_moodle');
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
    Schema::dropIfExists('activity_course_registered_users');
  }
}
