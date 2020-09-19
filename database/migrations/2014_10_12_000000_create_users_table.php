<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('rut', 15);
      $table->string('name', 200);
      $table->string('phone', 12)->nullable();
      $table->string('mobile', 12);
      $table->string('email', 255)->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password', 255);
      $table->tinyInteger('is_first_login');
      $table->rememberToken();
      $table->unsignedBigInteger('role_id');
      $table->timestamps();

      $table->foreign('role_id')->references('id')->on('roles');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
