<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory ;

    protected $fillable = [
        "name",
        "role_id",
        "permissions"
    ];

    protected $casts = [
        "permissions" => "array"
    ];


    ###################
    #### RELATIONS ####
    ###################

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function childrens()
    {
        return $this->hasMany(Role::class);
    }

    public function parent()
    {
        return $this->belongsTo(Role::class);
    }

}
