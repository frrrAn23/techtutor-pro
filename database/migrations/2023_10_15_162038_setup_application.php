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
        // roles
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });

        // users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('role_id')->after('id')->constrained('roles');
            $table->string('phone_number', 20)->nullable();
            $table->string('last_education', 50)->nullable();
            $table->string('status', 20)->default('active');
            $table->string('username')->unique();
            $table->text('avatar_url')->nullable();
        });

        // course categories
        Schema::create('course_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // courses
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->foreignUuid('author_id')->constrained('users');
            $table->text('thumbnail_url')->nullable();
            $table->string('status')->default('draft');
            $table->string('slug')->unique();
            $table->integer('level')->default(0);
            $table->foreignUuid('course_category_id')->constrained('course_categories');
            $table->json('labels')->nullable();
            $table->string('type')->default('text');
            $table->timestamps();
        });

        // topics
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('course_id')->constrained('courses');
            $table->string('order')->default(0);
            $table->timestamps();
        });

        // materials
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('course_id')->constrained('courses');
            $table->foreignUuid('topic_id')->constrained('topics');
            $table->longText('content')->nullable();
            $table->boolean('is_preview')->default(false);
            $table->string('status')->default('draft');
            $table->text('video_url')->nullable();
            $table->string('type')->default('lesson');
            $table->integer('duration_in_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // feedbacks
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('courses');
            $table->foreignUuid('user_id')->constrained('users');
            $table->text('comment');
            $table->integer('rating')->default(0);
            $table->timestamps();
        });

        // user access courses
        Schema::create('user_access_courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('courses');
            $table->foreignUuid('user_id')->constrained('users');
            $table->timestampTz('purchased_at');
            $table->timestampTz('completed_at')->nullable();
            $table->foreignUuid('last_material_id')->nullable()->constrained('materials');
            $table->string('status')->default('pending')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // user access courses
        Schema::dropIfExists('user_access_courses');

        // feedbacks
        Schema::dropIfExists('feedbacks');

        // materials
        Schema::dropIfExists('materials');

        // topics
        Schema::dropIfExists('topics');

        // courses
        Schema::dropIfExists('courses');

        // course categories
        Schema::dropIfExists('course_categories');

        // users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'phone_number', 'last_education', 'status', 'username', 'avatar_url', 'id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->id();
        });

        // roles
        Schema::dropIfExists('roles');
    }
};
