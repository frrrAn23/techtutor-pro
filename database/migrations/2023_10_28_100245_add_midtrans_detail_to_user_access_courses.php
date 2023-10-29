<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_access_courses', function (Blueprint $table) {
            $table->string('payment_status')->nullable();
            $table->string('snap_token', 36)->nullable();
            $table->integer('course_price')->nullable();
            $table->integer('course_retail_price')->nullable();
            $table->integer('payment_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_access_courses', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('snap_token');
            $table->dropColumn('course_price');
            $table->dropColumn('course_retail_price');
            $table->dropColumn('payment_amount');
        });
    }
};
