<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('appl_id')->nullable();//must be unique
            $table->string('title');
            $table->string('sname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('faculty_id');
            $table->string('prog_id');
            $table->string('email');
            $table->string('amt');
            $table->string('rrr')->nullable();
            $table->string('paid')->nullable()->default('N');
            $table->timestamps();

            $table->index('appl_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applies');
    }
}
