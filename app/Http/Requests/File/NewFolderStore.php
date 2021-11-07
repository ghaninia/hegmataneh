<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsSystem;
use Illuminate\Support\Facades\Gate;
use App\Rules\File\ExistsObjectNameRule;
use App\Rules\File\ExistsParentFolderRule;
use Illuminate\Foundation\Http\FormRequest;

class NewFolderStore extends FormRequest
{

    protected $user, $folder;

    public function prepareForValidation()
    {
        $this->user =  $this->route(EnumsSystem::WALLCARD_USER);
        $this->folder =  $this->route(EnumsSystem::WALLCARD_FOLDER);
    }

    /**
     * Determine if the user is authorized to make this request.
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
            "folder_name" => [
                "required",
                "string",
                "max:255",
                new ExistsObjectNameRule($this->user, $this->folder?->id)
            ],
        ];
    }
}
