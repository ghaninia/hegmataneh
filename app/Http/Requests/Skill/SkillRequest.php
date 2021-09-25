<?php

namespace App\Http\Requests\Skill;

use App\Models\Skill;
use App\Rules\SlugRule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{

    protected $skill;

    /**
     * Determine if the user is authorized to make this request.
     *
     SkillRequest* @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->skill = $this->route("skill");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "icon" => ["nullable", "string"],
            "translations" => ["required", "array", new TranslationableRule($this)],
            "translations.*.name" => ["required", "string", new SlugRule(Skill::class, $this->skill)],
            "translations.*.description" => ["nullable", "string"],
        ];
    }
}
