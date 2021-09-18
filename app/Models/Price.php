<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory, HasFilterTrait;

    protected $fillable = [
        "currency_id",
        "price",
        "priceable_id",
        "priceable_type",
        "amazing_status",
        "amazing_price",
        "amazing_from_date",
        "amazing_to_date",
    ];

    protected $casts = [
        "amazing_status" => "boolean"
    ];

    public function priceable()
    {
        return $this->morphTo("priceable");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
