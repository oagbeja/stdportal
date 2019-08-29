<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemitaPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remita_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rrr');
            $table->string('form_id');
            $table->string('amt_paid');
            $table->timestamps();

            $table->index('rrr');
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
        Schema::dropIfExists('remita_posts');
    }
}
