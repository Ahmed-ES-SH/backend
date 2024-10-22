<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        // استرجاع جميع الخدمات
        $services = DB::table('services')->pluck('id')->toArray();
        // استرجاع جميع الخدمات الفرعية
        $subServices = DB::table('sub_services')->pluck('id')->toArray();

        // قائمة بوصف الطلبات الواقعية
        $descriptions = [
            'طلب خدمة صيانة لجهاز تكييف.',
            'استفسار حول خدمات تصميم المواقع.',
            'طلب خدمة تنظيف منازل.',
            'استشارة قانونية بخصوص عقد.',
            'طلب توصيل سريع للمنتجات.',
            'استفسار عن خدمات تسويق الكتروني.',
            'طلب خدمة إصلاح أجهزة كهربائية.',
            'استشارة حول تحسين محركات البحث.',
            'طلب خدمة تركيب أنظمة أمان.',
            'استفسار حول خدمات تصوير احترافي.',
            'طلب خدمات صيانة دورية للمعدات.',
            'استشارة حول التأمين على الممتلكات.',
            'طلب خدمة استضافة مواقع.',
            'استفسار حول تصميم شعارات.',
            'طلب خدمة تعليم خاصة.',
            'استشارة حول التمويل الشخصي.',
            'طلب خدمات تصفيف شعر.',
            'استفسار حول خدمات الإعلانات المدفوعة.',
            'طلب خدمة تنظيم فعاليات.',
            'استشارة حول التخطيط المالي.'
        ];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('orders')->insert([
                'phone_number' => '050' . rand(1000000, 9999999), // رقم هاتف عشوائي
                'main_service' => $services[array_rand($services)], // اختيار خدمة عشوائية
                'sub_service' => $subServices[array_rand($subServices)], // اختيار خدمة فرعية عشوائية
                'request_description' => $descriptions[array_rand($descriptions)], // وصف الطلب من قائمة الوصف
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
