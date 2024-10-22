<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'client_name' => 'أحمد علي',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'خدمة رائعة وتجربة ممتازة!',
            ],
            [
                'client_name' => 'فاطمة الزهراء',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-3.jpg',
                'content' => 'فريق العمل محترف للغاية.',
            ],
            [
                'client_name' => 'محمد عبد الله',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-1.jpg',
                'content' => 'أنا راضٍ تمامًا عن النتائج.',
            ],
            [
                'client_name' => 'سارة محمد',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'خدمة العملاء ممتازة!',
            ],
            [
                'client_name' => 'علي السعيد',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-3.jpg',
                'content' => 'سأوصي بهذه الخدمة لأصدقائي.',
            ],
            [
                'client_name' => 'نور أحمد',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'تجربة مدهشة حقًا!',
            ],
            [
                'client_name' => 'خالد حسن',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'عمل رائع وفريق محترف.',
            ],
            [
                'client_name' => 'ليلى عمر',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'أحببت كل شيء حول الخدمة.',
            ],
            [
                'client_name' => 'محمود سعيد',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'تجربة رائعة من البداية إلى النهاية.',
            ],
            [
                'client_name' => 'أماني يوسف',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'فريق عمل متعاون وداعم.',
            ],
            [
                'client_name' => 'عبد الرحمن سالم',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'تجربة احترافية ورائعة.',
            ],
            [
                'client_name' => 'سعاد عيسى',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'فعلًا، هذه الخدمة تستحق التجربة.',
            ],
            [
                'client_name' => 'نادر فتحي',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'تعاون مثالي وجودة عالية.',
            ],
            [
                'client_name' => 'دنيا محمود',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'خدمة تفوق توقعاتي.',
            ],
            [
                'client_name' => 'سامي جاسم',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'شكرًا لكم على كل شيء.',
            ],
            [
                'client_name' => 'جنى لطفي',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'فريق العمل كان متعاونًا جدًا.',
            ],
            [
                'client_name' => 'يوسف كريم',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'أحببت التجربة وأتطلع للعودة.',
            ],
            [
                'client_name' => 'هالة هاني',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'كل شيء كان رائعًا وممتازًا.',
            ],
            [
                'client_name' => 'فهد مروان',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'أوصي بشدة بهذه الخدمة.',
            ],
            [
                'client_name' => 'مريم فريد',
                'client_image' => 'http://127.0.0.1:8000/users/avatar-2.jpg',
                'content' => 'تجربة لا تُنسى.',
            ],
        ];

        DB::table('testimonials')->insert($testimonials);
    }
}
