<?php

namespace App\Http\Requests\Filemanager;

use App\Kernel\Enums\EnumsFile;
use App\Rules\Filemanager\FolderRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilemanagerStore extends FormRequest
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
            "folder_id" => ["nullable" , new FolderRule($this->user ?? null) ] ,
            "attachments" => ["required" , "array"] ,
            "attachments.*" => [
                "required" ,
                "file",
                sprintf("mimetypes:%s" , implode("," , EnumsFile::mimes() ) )
            ]
        ];
    }
}
