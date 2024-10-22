<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'phone_number',
        'main_service',
        'sub_service',
        'order_status',
        'request_description',
    ];


    public function mainService()
    {
        return $this->belongsTo(Service::class, 'main_service');
    }

    public function subService()
    {
        return $this->belongsTo(sub_service::class, 'sub_service'); // العلاقة مع نموذج SubService
    }
}
