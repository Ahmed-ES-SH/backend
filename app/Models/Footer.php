<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'list1',
        'list2',
        'list3',
        'list4',
        'list5',
    ];

    protected $casts = [
        'list1' => 'array',
        'list2' => 'array',
        'list3' => 'array',
        'list4' => 'array',
        'list5' => 'array',
    ];
}
