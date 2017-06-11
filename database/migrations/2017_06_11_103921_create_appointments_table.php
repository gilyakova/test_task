<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datetime');
            $table->string('place');
            $table->string('contacts', 2000)->nullable();
            $table->integer('company_id');
            $table->integer('person_id')->nullable();
            $table->string('note', 2000)->nullable();
            $table->string('status', 10)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down($status = 'active', $limit = '10', $offset = '1')
    {
        Schema::dropIfExists('appointments');
    }
}
