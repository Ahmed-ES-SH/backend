<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'aboutcontent_en',
        'aboutcontent_ar',
        'goals_en',
        'goals_ar',
        'value_en',
        'value_ar',
        'vision_en',
        'vision_ar',
        "address",
        "about_image",
        "vision_image",
        "goals_image",
        "values_image",
        'whatsapp_number',
        'gmail_account',
        'show_map',
    ];
}
