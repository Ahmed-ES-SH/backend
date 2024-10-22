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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar'); // اسم المشروع
            $table->string('title_en'); // اسم المشروع
            $table->text('description_ar')->nullable(); // وصف المشروع
            $table->text('description_en')->nullable(); // وصف المشروع
            $table->string('image')->nullable();
            $table->date('completion_date')->nullable(); // تاريخ الإنجاز
            $table->string('project_link')->nullable(); // رابط المشروع
            $table->string('client_name')->nullable(); // اسم العميل
            $table->string('category')->nullable(); // فئة المشروع
            $table->string('video_link')->nullable(); // رابط الفيديو
            $table->text('awards')->nullable(); // الجوائز أو الإشادات
            $table->json('technologies_used')->nullable(); // الأدوات والتقنيات المستخدمة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
