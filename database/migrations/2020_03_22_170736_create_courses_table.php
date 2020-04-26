<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('courses', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('description', 100);
      $table->unsignedBigInteger('id_course_moodle');
      $table->unsignedBigInteger('category_id');
      $table->unsignedInteger('status')->default(1);
      $table->timestamps();

      $table->foreign('category_id')->references('id')->on('categories');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('courses');
  }
}
