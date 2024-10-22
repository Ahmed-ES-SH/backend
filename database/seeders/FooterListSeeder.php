<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Footer;

class FooterListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Footer::create([
            'list1' => json_encode([
                ['name' => 'Home', 'url' => '/home'],
                ['name' => 'About Us', 'url' => '/about'],
                ['name' => 'Contact', 'url' => '/contact']
            ]),
            'list2' => json_encode([
                ['name' => 'Services', 'url' => '/services'],
                ['name' => 'Portfolio', 'url' => '/portfolio'],
                ['name' => 'Careers', 'url' => '/careers']
            ]),
            'list3' => json_encode([
                ['name' => 'Blog', 'url' => '/blog'],
                ['name' => 'News', 'url' => '/news'],
                ['name' => 'Press', 'url' => '/press']
            ]),
            'list4' => json_encode([
                ['name' => 'Privacy Policy', 'url' => '/privacy-policy'],
                ['name' => 'Terms of Service', 'url' => '/terms'],
                ['name' => 'Support', 'url' => '/support']
            ]),
            'list5' => json_encode([
                ['name' => 'FAQ', 'url' => '/faq'],
                ['name' => 'Help Center', 'url' => '/help-center'],
                ['name' => 'Contact Sales', 'url' => '/contact-sales']
            ]),
        ]);
    }
}
