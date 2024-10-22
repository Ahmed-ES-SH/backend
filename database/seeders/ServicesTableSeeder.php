<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title_en' => 'Marketing Strategies',
                'title_ar' => 'استراتيجيات التسويق',
                'description_en' => 'Marketing strategies are a comprehensive plan that aims to identify the target audience, develop products, and choose the appropriate channels to increase brand awareness and achieve sales goals.',
                'description_ar' => 'استراتيجيات التسويق هي خطة شاملة تهدف إلى تحديد الجمهور المستهدف وتطوير المنتجات واختيار القنوات المناسبة لزيادة الوعي بالعلامة التجارية وتحقيق أهداف المبيعات.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Digital Marketing',
                'title_ar' => 'التسويق الرقمي',
                'description_en' => 'Digital marketing encompasses all marketing efforts that use the internet or electronic devices to connect with potential customers, including social media, email marketing, and online advertising.',
                'description_ar' => 'التسويق الرقمي يشمل جميع الجهود التسويقية التي تستخدم الإنترنت أو الأجهزة الإلكترونية للتواصل مع العملاء المحتملين، بما في ذلك وسائل التواصل الاجتماعي، والتسويق عبر البريد الإلكتروني، والإعلانات عبر الإنترنت.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Brand Identity Design',
                'title_ar' => 'تصميم هوية العلامة التجارية',
                'description_en' => 'Brand identity design involves creating a unique image and representation for a brand through visual elements like logos, color palettes, and typography, ensuring a cohesive presence in the market.',
                'description_ar' => 'تصميم هوية العلامة التجارية يتضمن إنشاء صورة فريدة وتمثيل للعلامة التجارية من خلال عناصر بصرية مثل الشعارات، ولوحات الألوان، والطباعة، مما يضمن وجودًا متماسكًا في السوق.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Search Engine Optimization (SEO)',
                'title_ar' => 'تحسين محركات البحث (SEO)',
                'description_en' => 'SEO is the practice of optimizing a website to improve its visibility in search engine results, enhancing organic traffic through strategies like keyword research, on-page optimization, and link building.',
                'description_ar' => 'تحسين محركات البحث (SEO) هو ممارسة تحسين موقع الويب لتحسين ظهوره في نتائج محركات البحث، وزيادة الحركة العضوية من خلال استراتيجيات مثل بحث الكلمات الرئيسية، وتحسين الصفحة، وبناء الروابط.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Influencer Marketing',
                'title_ar' => 'التسويق عبر المؤثرين',
                'description_en' => 'Influencer marketing focuses on partnering with popular figures in social media to promote products or services, leveraging their reach and credibility to engage with target audiences effectively.',
                'description_ar' => 'التسويق عبر المؤثرين يركز على الشراكة مع شخصيات مشهورة على وسائل التواصل الاجتماعي للترويج للمنتجات أو الخدمات، مستفيدًا من وصولهم ومصداقيتهم للتفاعل بفعالية مع الجمهور المستهدف.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Technical Services',
                'title_ar' => 'الخدمات التقنية',
                'description_en' => 'Technical services involve providing specialized support and solutions in areas such as web development, software engineering, and IT consulting to enhance business operations.',
                'description_ar' => 'تشمل الخدمات التقنية تقديم الدعم المتخصص والحلول في مجالات مثل تطوير الويب، وهندسة البرمجيات، والاستشارات التقنية لتعزيز عمليات الأعمال.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Economic Consulting',
                'title_ar' => 'الاستشارات الاقتصادية',
                'description_en' => 'Economic Consulting involves the application of economic theories and methodologies to provide insights and solutions for businesses, governments, and organizations.',
                'description_ar' => 'تشمل الاستشارات الاقتصادية تطبيق النظريات والأساليب الاقتصادية لتوفير رؤى وحلول للشركات والحكومات والمنظمات.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
            [
                'title_en' => 'Roadside ads',
                'title_ar' => 'الإعلانات على جانب الطريق',
                'description_en' => 'Roadside ads are effective marketing tools that capture the attention of drivers and pedestrians, promoting brand visibility and increasing awareness.',
                'description_ar' => 'تعتبر الإعلانات على جانب الطريق أدوات تسويقية فعالة تجذب انتباه السائقين والمشاة، مما يعزز رؤية العلامة التجارية ويزيد من الوعي.',
                'features' => json_encode(['Social Media', 'Email Marketing', 'Online Advertising']),
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert($service);
        }
    }
}
