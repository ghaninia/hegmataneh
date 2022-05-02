<?php

namespace App\Http\Requests\Filemanager;

use Illuminate\Foundation\Http\FormRequest;

class FilemanagerIndex extends FormRequest
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
            "current_page" => ["nullable", "numeric"],
            "folder_id" => ["nullable", "exists:files,id"],
            "name" => ["nullable", "string"],
        ];
    }
}
