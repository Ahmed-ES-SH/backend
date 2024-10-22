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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('content_en');
            $table->text('content_ar');
            $table->string('author');
            $table->timestamp('published_date')->default(now());
            $table->string('category'); // إذا كنت تستخدم جدول الفئات
            $table->string('tags')->nullable();
            $table->string('image')->nullable(); // عمود الصور كمصفوفة JSON
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->text('excerpt')->nullable();
            $table->json('interactions')->nullable(); // عمود لتخزين التفاعلات
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
