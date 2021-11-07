<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsFile;
use App\Core\Enums\EnumsSystem;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class FileIndex extends FormRequest
{

    protected $user, $file, $folder;

    public function prepareForValidation()
    {
        $this->user =  $this->route(EnumsSystem::WALLCARD_USER);
        $this->folder =  $this->route(EnumsSystem::WALLCARD_FOLDER);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::forUser($this->user)->allows('dir', $this->folder);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            "name" => ["nullable", "string", "max:255"],
            "extension" => ["nullable", "string"],
            "mime_type" => ["nullable", Rule::in(EnumsFile::mimes())],

            "type" => ["nullable", "array"],
            "type.*" => ["required", Rule::in(EnumsFile::type())],

            "has_recursive" => ["nullable", "boolean"],

            "order_by" => [
                "nullable",
                Rule::in([
                    "extension",
                    "mime_type",
                    "name",
                    "size",
                    "type"
                ])
            ],

            "order" => [
                "nullable",
                Rule::in([
                    EnumsSystem::ORDER_DESC,
                    EnumsSystem::ORDER_ASC,
                ])
            ]
        ];
    }
}
