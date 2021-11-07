<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsSystem;
use Illuminate\Support\Facades\Gate;
use App\Rules\File\ExistsObjectNameRule;
use Illuminate\Foundation\Http\FormRequest;

class FileRenameUpdate extends FormRequest
{

    protected $user, $file;

    public function prepareForValidation()
    {
        $this->user =  $this->route(EnumsSystem::WALLCARD_USER);
        $this->file =  $this->route(EnumsSystem::WALLCARD_FILE);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::forUser($this->user)->allows('file', $this->file);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $parentId = $this->file->file_id;

        return [
            "new_name" => [
                "required", "string", "max:255",
                new ExistsObjectNameRule($this->user, $parentId)
            ]
        ];
    }
}
