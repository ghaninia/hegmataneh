<?php

namespace App\Models;

use App\Core\Interfaces\FilterableInterface;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model implements FilterableInterface
{
    use HasFactory, HasFilterTrait;

    protected $fillable = [
        'user_id',
        'user_ip',
        'post_id',
        'vote'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filterNamespace(): string
    {
        return "App\\Contracts\\Filters\\VoteFilters";
    }
}
