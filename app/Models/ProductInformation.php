<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        "post_id" ,
        "maximum_sell" ,
        "expire_day" ,
        "download_limit" ,
    ];

    public function post()
    {
        return $this->hasOne( Post::class );
    }

}
