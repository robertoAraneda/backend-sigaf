<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('alerts', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('ticket_id');
      $table->unsignedBigInteger('user_id');
      $table->time('time');
      $table->date('date');
      $table->unsignedInteger('status_reminder')->default(0);
      /**crea alerta*/
      $table->unsignedInteger('status_notification')->default(1);
      /**crea notificación en campanita*/
      $table->string('comment');
      $table->timestamps();

      $table->foreign('ticket_id')->references('on')->on('tickets');
      $table->foreign('user_id')->references('on')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('alerts');
  }
}
