<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sub_service extends Model
{
    protected $fillable = ['service_id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'image', 'images'];



    protected $casts = [
        'images' => 'array', // تحويل الصور إلى مصفوفة
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class); // العلاقة مع نموذج Service
    }
}
