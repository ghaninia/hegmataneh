<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "currency_id",
        "gateway_id",
        "ipv4",
        "status",
        "ref_id",
        "transaction_id",
        "tracking_code",
        "total_price", ### قیمت بدون احتساب تخفیف
        "total_discount", ### مجموع تخفیف
        "total_final_price", ### قیمت نهایی
    ];

    public $dates = [
        "deleted_at"
    ];


    ###################
    #### RELATIONS ####
    ###################


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class) ;
    }

    ################
    #### SCOPES ####
    ################

    public function getRouteKeyName()
    {
        return "tracking_code";
    }
}
