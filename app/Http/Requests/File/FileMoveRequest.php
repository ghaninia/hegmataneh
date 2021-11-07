<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsSystem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class FileMoveRequest extends FormRequest
{

    protected $user, $file, $folder;

    public function prepareForValidation()
    {
        $this->user =  $this->route(EnumsSystem::WALLCARD_USER);
        $this->file =  $this->route(EnumsSystem::WALLCARD_FILE);
        $this->folder =  $this->route(EnumsSystem::WALLCARD_FOLDER);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return
            Gate::forUser($this->user)->allows('file', $this->file) &&
            Gate::forUser($this->user)->allows('dir', $this->folder);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
