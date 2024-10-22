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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_en'); // عنوان الخدمة
            $table->string('title_ar'); // عنوان الخدمة
            $table->text('description_en'); // وصف الخدمة
            $table->text('description_ar'); // وصف الخدمة
            $table->json('features'); // مميزات الخدمة (مصفوفة)
            $table->decimal('expected_benefit_percentage', 5, 2)->nullable(); // نسبة الاستفادة المتوقعة
            $table->decimal('starting_price', 10, 2)->nullable(); // سعر ابتدائي للخدمة
            $table->text('icon')->nullable();
            $table->json('images')->nullable(); // صور الخدمة (مصفوفة)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
