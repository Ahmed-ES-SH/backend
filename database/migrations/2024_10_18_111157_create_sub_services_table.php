<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');  // المفتاح الخارجي للإشارة إلى الخدمة الأساسية
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();

            // إضافة المفتاح الخارجي
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');  // هذا الخيار يتيح حذف الخدمات الفرعية عند حذف الخدمة الأساسية
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_services');
    }
};
