<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class forth_section extends Model
{
    protected  $fillable = [
        'text1_en',
        'text1_ar',
        'text2_en',
        'text2_ar',
        'text3_en',
        'text3_ar',
        'image',
        'FAQ_image',
        'contact_img',
    ];
}
