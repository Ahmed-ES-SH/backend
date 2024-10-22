<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
{
    $faker = Faker::create();
    $urlimage = 'http://127.0.0.1:8000'; // الرابط الأساسي
    $path = 'users'; // المسار النسبي لمجلد الصور
    $fullpath = public_path($path); // المسار الكامل للمجلد
    $images = scandir($fullpath); // قراءة الملفات في المجلد
    // تصفية الصور بالامتدادات المطلوبة
    $imagesarray = array_filter($images, function ($image) {
        return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    });

    for ($i = 0; $i < 50; $i++) {
        $imageuser = $imagesarray[array_rand($imagesarray)]; // اختيار صورة عشوائية
        $imageurl = $urlimage . '/' . $path . '/' . $imageuser; // إنشاء الرابط الكامل للصورة
        DB::table('users')->insert([
            'name' => $faker->name,
            'last_name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'image' => $imageurl, // إضافة الرابط الكامل للصورة
            'created_at' => now(),
            'password' => Hash::make('password')
        ]);
    }
}

}
