<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        "file_id",
        "fullname",
        "career",
        "text",
        "pin"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
