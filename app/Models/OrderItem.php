<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Pivot
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "order_id" ,
        "downloads_count",
        "token",
        "price",
        "expire_at"
    ];

    protected $guarded = [
        "token",
    ];

    public $dates = [
        "expire_at"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function product()
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    public function order()
    {
        return $this->belongsTo(Order::class) ;
    }

}
