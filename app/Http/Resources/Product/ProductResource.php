<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "type" => $this->type ,
            "status"  => $this->status ,
            "comment_status" => $this->comment_status ,
            "vote_status" => $this->vote_status ,
            "format" => $this->format ,
            "development" => $this->development ,
            "title" => $this->title ,
            "goal_post" => $this->goal_post ,
            "slug" => $this->slug ,
            "content" => $this->content ,
            "excerpt" => $this->excerpt ,
            "faq" => $this->faq ,
            "theme" => $this->theme ,
            "price" => $this->price ,
            "sale_price" => $this->sale_price ,
            "maximum_sell" => $this->maximum_sell ,
            "expire_day" => $this->expire_day ,
            "download_limit" => $this->download_limit ,
            "sale_price_dates_from" => $this->sale_price_dates_from ,
            "sale_price_dates_to" => $this->sale_price_dates_to ,
            "published_at" => $this->published_at ,
            "created_at" => $this->created_at ,
            "user"  => new UserResource($this->whenLoaded("user"))
        ];
    }
}
