<?php

namespace App\Http\Resources\Translation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TranslationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->groupBy("language.code") ;
    }
}
