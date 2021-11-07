<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsFile;
use App\Core\Enums\EnumsSystem;
use App\Rules\File\ExistsObjectNameRule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class FileUploadStore extends FormRequest
{

    protected $user, $folder;

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
        $mimetypes = implode(',', EnumsFile::mimes());

        return [
            "attachment" => [
                "required",
                "file",
                "mimetypes:$mimetypes",
                new ExistsObjectNameRule($this->user, $this->folder)
            ]
        ];
    }
}
