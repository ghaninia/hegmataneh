<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id ,
            'fullname' => $this->fullname ,
            'email' => $this->email ,
            'website' => $this->website ,
            'ipv4' => $this->ipv4 ,
            'status' => $this->status ,
            'content' => $this->content ,
            'parent' => new CommentResource( $this->whenLoaded("parent") ),
            'childrens' => new CommentCollection( $this->whenLoaded("childrens") ),
            'post' => new PostResource( $this->whenLoaded("post") ),
            'user' => new UserResource( $this->whenLoaded("user") ) ,
        ];
    }
}
