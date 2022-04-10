<?php

namespace App\Http\Requests\Product;

use App\Kernel\Enums\EnumsPost;
use App\Rules\FilterRangeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "comment_status" => [ "nullable" , "boolean" ] ,
            "vote_status" => [ "nullable" , "boolean" ] ,
            "status" => [ "nullable" , Rule::in( EnumsPost::status() ) ] ,
            "slug" => [ "nullable" , "string" ] ,
            "title" => [ "nullable" , "string" ] ,
            "content" => [ "nullable" , "string" ] ,
            "created_at" => ["nullable" , "array" , new FilterRangeRule ] ,
            "created_at.*" => ["nullable" , "date" ] ,
            "published_at" => ["nullable" , "array" , new FilterRangeRule ] ,
            "published_at.*" => ["nullable" , "date" ] ,
            "price" => ["nullable", "array", new FilterRangeRule],
            "price.*" => ["required", "numeric"],
            "amazing_price" => ["nullable", "array", new FilterRangeRule],
            "amazing_price.*" => ["required", "numeric"],
        ];
    }
}
