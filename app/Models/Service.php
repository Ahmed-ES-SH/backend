<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'features',
        'expected_benefit_percentage',
        'starting_price',
        'images',
        'icon',
        'sub_category_id',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subServices()
    {
        return $this->hasMany(sub_service::class);
    }
}
