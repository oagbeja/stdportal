<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_id')->unique();//must be unique
            $table->string('title');
            $table->string('sname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('faculty_id');
            $table->string('prog_id');
            $table->string('email');
            $table->string('image')->nullable();
            $table->text('caddress')->nullable();
            $table->bigInteger('phonenum')->nullable();
            
            $table->bigInteger('nokphonenum')->nullable();
            $table->text('nokcaddress')->nullable();
            $table->text('olevel1')->nullable();
            $table->text('olevel2')->nullable();
            $table->text('other_qual')->nullable();
            $table->text('comments')->nullable();
            $table->char('subm')->default('N');
            $table->timestamps();

            $table->index('form_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
