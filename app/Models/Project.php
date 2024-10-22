<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        "image",
        "completion_date",
        "project_link",
        "client_name",
        "category",
        "video_link",
        "awards",
        "technologies_used",
    ];

    protected $casts = [
        'technologies_used' => 'array', // تحويل technologies_used إلى مصفوفة
    ];
}
