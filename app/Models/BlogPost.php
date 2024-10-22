<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;


    protected $fillable = [
        'title_ar',
        'title_en',
        'content_en',
        'content_ar',
        'author',
        'published_date',
        'category',
        'tags',
        'image',
        'images',
        'status',
        'views',
        'comments_count',
        'excerpt',
        'interactions', // إضافة العمود للتفاعلات
    ];

    protected $casts = [
        'images' => 'array', // تحويل images إلى مصفوفة
        'interactions' => 'array', // تحويل interactions إلى مصفوفة
    ];


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
