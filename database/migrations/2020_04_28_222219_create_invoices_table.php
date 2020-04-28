<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('comment_id')->nullable()->default(null);
            $table->unsignedInteger('article_id')->nullable()->default(null);
            $table->integer('credit')->default(0);
            $table->integer('debit')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('restrict');

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
