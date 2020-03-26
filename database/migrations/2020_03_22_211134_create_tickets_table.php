<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tickets', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('course_registered_user_id');
      $table->unsignedBigInteger('in_out_ticket_id');
      /**entrante-saliente*/
      $table->unsignedBigInteger('status_ticket_id');
      /**abierto-cerrado*/
      $table->unsignedBigInteger('priority_ticket_id');
      /**alta-media-baja*/
      $table->unsignedBigInteger('motive_ticket_id');
      /**bienvenida-problema...*/
      $table->unsignedBigInteger('user_create_id')->default(1);
      $table->unsignedBigInteger('user_assigned_id');
      $table->timestamp('closing_date')->nullable();
      $table->text('observation')->nullable();
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
    Schema::dropIfExists('tickets');
  }
}
