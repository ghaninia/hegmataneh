<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use App\Models\User;
use App\Rules\SlugRule;
use App\Core\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdate extends FormRequest
{

    public User $user;
    public Post $post;

    public function prepareForValidation()
    {
        $this->user = $this->route("user");
        $this->post = $this->route("post");
    }

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
        return [] ;
        // $statsSchedule = EnumsPost::STATUS_SCHEDULE;

        // return [
        //     "title" => ["required", "string"],
        //     "slug" => [new SlugRule(Post::class, "title", $this->post)],

        //     "status" => ["required", Rule::in(EnumsPost::status())],
        //     "comment_status" => ["required", "boolean"],
        //     "vote_status" => ["required", "boolean"],
        //     "format" => ["required", Rule::in(EnumsPost::format())],
        //     "content" => ["nullable", "string"],
        //     "excerpt" => ["nullable", "string"],
        //     "faq" => ["nullable", "string"],
        //     "published_at" => ["nullable", "required_if:status,{$statsSchedule}", "date"],
        //     "created_at" => ["nullable", "date"],

        //     "tags" => ["nullable", "array"],
        //     "tags.*" => ["required", "exists:terms,id"],

        //     "categories" => ["nullable", "array"],
        //     "categories.*" => ["required", "exists:terms,id"],
        // ];
    }
}
