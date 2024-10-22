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

        Schema::create('company_information', function (Blueprint $table) {
            $table->id();
            $table->text('whatsapp_number'); // اسم الشركة
            $table->text('gmail_account'); // اسم الشركة
            $table->text('aboutcontent_ar'); // اسم الشركة
            $table->text('aboutcontent_en'); // اسم الشركة
            $table->text('vision_ar'); // اسم الشركة
            $table->text('vision_en'); // اسم الشركة
            $table->text('goals_ar'); // اسم الشركة
            $table->text('goals_en'); // اسم الشركة
            $table->text('values_en'); // اسم الشركة
            $table->text('values_ar'); // رؤية الشركة
            $table->text('show_map'); // رؤية الشركة
            $table->string('address')->nullable(); // عنوان الشركة (اختياري)
            $table->string('about_image')->nullable(); // رقم الهاتف (اختياري)
            $table->string('vision_image')->nullable(); // مسار صورة الرؤية
            $table->string('goals_image')->nullable(); // مسار صورة الأهداف
            $table->string('values_image')->nullable(); // مسار صورة القيم
            $table->timestamps(); // تسجيل تاريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_information');
    }
};
