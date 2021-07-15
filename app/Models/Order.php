<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "ipv4",
        "status",
        "ref_id",
        "transaction_id",
        "tracking_code",
        "price"
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


    ################
    #### SCOPES ####
    ################

    public function getRouteKeyName()
    {
        return "tracking_code";
    }
}
