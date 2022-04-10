<?php

namespace App\Http\Requests\User\Detail;

use App\Rules\FilterRangeRule;
use Illuminate\Validation\Rule;
use App\Kernel\Enums\EnumsComment;
use Illuminate\Foundation\Http\FormRequest;

class DetailUserCommentStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment_id' => ["nullable", "numeric", "exists:comments,comment_id"],
            'post_id' => ["nullable", "numeric", "exists:posts,id"],
            'fullname' => ["nullable", "string"],
            'email' => ["nullable", "string", "email"],
            'website' => ["nullable", "string", "url"],
            'ipv4' => ["nullable", "string", "ipv4"],
            'status' => ["nullable", "string", Rule::in(EnumsComment::status())],
            'content' => ["nullable", "string"],

            "created_at" => ["nullable" , new FilterRangeRule ],
            "created_at.*" => ["required" , "date_format:Y/m/d" ],
        ];
    }
}
