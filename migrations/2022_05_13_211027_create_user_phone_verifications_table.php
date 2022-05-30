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
        Schema::create('user_phone_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('code');
            $table->boolean('is_canceled')->default(false);
            $table->timestamps();

            $table->index(['is_canceled', 'created_at']);
            $table->index(['phone', 'is_canceled', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_verifications');
    }
};
