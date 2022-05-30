<?php

use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
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
        Schema::create('user_oauth_credentials', function (Blueprint $table) {
            $table->id();
            $table->enum('driver', array_column(DriverEnum::cases(), 'value'));
            $table->string('remote_id')->index();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_oauth_credentials');
    }
};
