<?php

namespace App\Models;

use App\Core\Enums\EnumsComment;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment_id',
        'post_id',
        'user_id',
        'fullname',
        'email',
        'website',
        'ipv4',
        'status',
        'content'
    ];

    ################
    #### SCOPES ####
    ################

    public function scopePublished($query)
    {
        $query->where('status', EnumsComment::STATUS_TRUE);
    }

    public function scopeRejected($query)
    {
        $query->where('status', EnumsComment::STATUS_FALSE);
    }

    ###################
    #### RELATIONS ####
    ###################

    public function likes()
    {
        return $this->morphMany(Like::class, "likeable");
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function childs()
    {
        return $this->hasMany(Comment::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class);
    }
}
