<?php

namespace App\Http\Requests\File;

use App\Core\Enums\EnumsFile;
use Illuminate\Foundation\Http\FormRequest;

class FileStore extends FormRequest
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
            "attachments" => ["required", "array"],
            "attachments.*" => ["required", "mimetypes:" . implode(",", EnumsFile::mimes())]
        ];
    }
}
