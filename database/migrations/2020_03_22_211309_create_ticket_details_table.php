<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ticket_details', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('ticket_id');
      $table->unsignedBigInteger('user_create_id');
      $table->unsignedBigInteger('status_detail_ticket_id');
      $table->string('comment');
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
    Schema::dropIfExists('ticket_details');
  }
}
