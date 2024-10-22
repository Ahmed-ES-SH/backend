<?php

namespace Database\Seeders;

use App\Models\sub_service;
use Illuminate\Database\Seeder;
use App\Models\SubService;
use Illuminate\Support\Facades\DB;

class SubServiceSeeder extends Seeder
{
    public function run()
    {
        // جلب جميع IDs الخاصة بالخدمات من قاعدة البيانات
        $serviceIds = DB::table('services')->pluck('id')->toArray();

        // عدد الخدمات الفرعية التي تريد إضافتها
        $numberOfSubServices = 20;

        // إنشاء خدمات فرعية بشكل عشوائي
        for ($i = 1; $i <= $numberOfSubServices; $i++) {
            $subService = [
                'service_id' => $serviceIds[array_rand($serviceIds)], // اختيار service_id عشوائيًا
                'title_en' => 'Sub Service ' . "--------" . $i,
                'title_ar' => 'الخدمة الفرعية ' . "--------" . $i,
                'description_en' => 'Description for Sub Service ' . "--------" . $i,
                'description_ar' => 'وصف الخدمة الفرعية ' . "--------" . $i,
            ];

            // إنشاء الخدمة الفرعية
            sub_service::create($subService);
        }
    }
}
