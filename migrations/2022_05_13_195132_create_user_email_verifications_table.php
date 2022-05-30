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
        Schema::create('user_email_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('credential_id')->index();
            $table->string('email');
            $table->string('code');
            $table->boolean('is_canceled')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('credential_id')->references('id')->on('user_email_credentials')->onDelete('CASCADE');

            $table->index(['is_canceled', 'created_at']);
            $table->index(['email', 'is_canceled', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_email_verifications');
    }
};
