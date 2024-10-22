<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title_en' => 'Project One',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project one.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Four',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project four.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Five',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project five.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Six',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project six.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Seven',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project seven.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Eight',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project eight.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Two',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project two.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Ten',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project ten.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Eleven',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project eleven.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Twelve',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project twelve.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Three',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project three.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project Nine',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project nine.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 13',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 13.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 14',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 14.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 15',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 15.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 16',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 16.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 17',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 17.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
            [
                'title_en' => 'Project 18',
                'title_ar' => 'عنوان المشروع',
                'description_en' => 'This is the description_en for Project 18.',
                'description_ar' => 'وصف المشروع باللقة العربية .',
                'technologies_used' => json_encode(["skill - 1", "skill - 2", "skill - 3", "skill - 4"]),
            ],
        ];

        foreach ($projects as $project) {
            DB::table('projects')->insert($project);
        }
    }
}
