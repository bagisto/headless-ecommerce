<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notification_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->string('locale');
            $table->string('channel');
            $table->bigInteger('push_notification_id')->unsigned();

            $table->unique(['push_notification_id', 'locale', 'channel'], 'push_notification_translations_locale_unique');

            $table->foreign('push_notification_id')->references('id')->on('push_notifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_notification_translations');
    }
};
