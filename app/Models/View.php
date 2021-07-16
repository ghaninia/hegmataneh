<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Interfaces\FilterableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model implements FilterableInterface
{

    use HasFilterTrait , HasFactory;

    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'user_id',
        'user_ip',
        'marked'
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewable()
    {
        return $this->morphTo();
    }

    ################
    #### SCOPES ####
    ################

    public function filterNamespace(): string
    {
        return "\\App\\Contracts\\Filters\\ViewFilters";
    }
}
