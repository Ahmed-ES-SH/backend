<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $blogs = [
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'Clever ways to invest in product to organize your portfolio',
                'content_en' => 'Discover smart investment strategies to streamline and organize your portfolio.',
                'title_ar' => 'طرق ذكية للاستثمار في المنتج لتنظيم محفظتك',
                'content_ar' => 'اكتشف استراتيجيات الاستثمار الذكية لتبسيط وتنظيم محفظتك.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'How to grow your profit through systematic investment with us',
                'content_en' => 'Unlock the power of systematic investment with us and watch your profits soar.',
                'title_ar' => 'كيف تنمي أرباحك من خلال الاستثمار المنظم معنا',
                'content_ar' => 'افتح قوة الاستثمار المنظم معنا وراقب أرباحك تتصاعد.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'How to analyze every holdings of your portfolio',
                'content_en' => 'Our comprehensive guide will equip you with the tools and insights needed.',
                'title_ar' => 'كيف تحلل جميع استثمارات محفظتك',
                'content_ar' => 'دليلنا الشامل سيوفر لك الأدوات والرؤى اللازمة.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'Investing in the future: Trends to watch',
                'content_en' => 'Stay ahead of the curve by understanding future investment trends.',
                'title_ar' => 'الاستثمار في المستقبل: الاتجاهات التي يجب مراقبتها',
                'content_ar' => 'ابق في الصدارة من خلال فهم اتجاهات الاستثمار المستقبلية.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'The importance of diversification in your portfolio',
                'content_en' => 'Learn why diversifying your investments is crucial for long-term success.',
                'title_ar' => 'أهمية التنويع في محفظتك',
                'content_ar' => 'تعلم لماذا يعد تنويع استثماراتك أمرًا بالغ الأهمية لتحقيق النجاح على المدى الطويل.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'How to create a balanced investment strategy',
                'content_en' => 'Discover how to balance risk and reward in your investment portfolio.',
                'title_ar' => 'كيفية إنشاء استراتيجية استثمار متوازنة',
                'content_ar' => 'اكتشف كيفية تحقيق التوازن بين المخاطر والمكافآت في محفظتك الاستثمارية.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'Real estate investment: A guide for beginners',
                'content_en' => 'Get started with real estate investing and learn the basics.',
                'title_ar' => 'استثمار العقارات: دليل للمبتدئين',
                'content_ar' => 'ابدأ في استثمار العقارات وتعلم الأساسيات.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'Understanding stocks and bonds: What you need to know',
                'content_en' => 'A primer on the differences and benefits of stocks and bonds.',
                'title_ar' => 'فهم الأسهم والسندات: ما تحتاج إلى معرفته',
                'content_ar' => 'مقدمة عن الاختلافات وفوائد الأسهم والسندات.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'How to read financial statements like a pro',
                'content_en' => 'Learn how to interpret financial statements to make informed decisions.',
                'title_ar' => 'كيفية قراءة البيانات المالية مثل المحترفين',
                'content_ar' => 'تعلم كيفية تفسير البيانات المالية لاتخاذ قرارات مستنيرة.',
            ],
            [
                'author' => 'Admin',
                'category' => 'test  catgeory',
                'published_date' => '2024-10-19',
                'title_en' => 'The impact of market trends on your investments',
                'content_en' => 'Understand how market trends affect your investment strategy.',
                'title_ar' => 'أثر الاتجاهات السوقية على استثماراتك',
                'content_ar' => 'افهم كيف تؤثر الاتجاهات السوقية على استراتيجيتك الاستثمارية.',
            ],
        ];

        foreach ($blogs as $blog) {
            BlogPost::create($blog);
        }
    }
}
