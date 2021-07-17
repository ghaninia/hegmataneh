<?php

namespace App\Http\Requests\User\Detail;

use App\Core\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DetailUserPageStore extends FormRequest
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
            "comment_status" => ["nullable", "boolean"],
            "vote_status" => ["nullable", "boolean"],
            "status" => ["nullable", Rule::in(EnumsPost::status())],
            "format" => ["nullable", Rule::in(EnumsPost::format())],
            "slug" => ["nullable", "string"],
            "title" => ["nullable", "string"],
            "content" => ["nullable", "string"],
            "theme" => ["nullable", "string"],
        ];
    }
}
