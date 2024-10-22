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


        Schema::create('third_sections', function (Blueprint $table) {
            $table->id();
            $table->string('text1_en'); // النص الإنجليزي
            $table->string('text1_ar'); // النص العربي
            $table->string('text2_en'); // النص الإنجليزي
            $table->string('text2_ar'); // النص العربي
            $table->string('image')->nullable(); // الصورة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_sections');
    }
};
