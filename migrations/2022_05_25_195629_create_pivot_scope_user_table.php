<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_scope_user', function (Blueprint $table) {
            $table->unsignedBigInteger('scope_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->foreign('scope_id')->references('id')->on('scopes')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->index(['scope_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_scope_user');
    }
};
