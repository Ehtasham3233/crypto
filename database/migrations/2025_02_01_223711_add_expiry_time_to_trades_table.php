<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->timestamp('expiry_time')->after('duration'); // Adding expiry_time column
        });
    }

    public function down()
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn('expiry_time');
        });
    }
};