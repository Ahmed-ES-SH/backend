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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // رقم الهاتف
            $table->string('main_service'); // الخدمة الرئيسية
            $table->string('sub_service'); // الخدمة الفرعية
            $table->string('order_status'); // الخدمة الفرعية
            $table->text('request_description'); // وصف الطلب
            $table->timestamps(); // تاريخ ووقت الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
