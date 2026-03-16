<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            $table->unsignedBigInteger('chat_channel_id')->nullable()->after('id');
            $table->unsignedBigInteger('user_id')->nullable()->after('chat_channel_id');
            $table->text('message')->nullable()->after('user_id');

        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            $table->dropColumn(['chat_channel_id','user_id','message']);

        });
    }
};