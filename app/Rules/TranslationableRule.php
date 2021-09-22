<?php

namespace App\Rules;

use App\Core\Enums\EnumsOption;
use App\Repositories\Language\LanguageRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class TranslationableRule implements Rule
{
    protected $systemDefaultLanguage ;

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $request , $message ;

    public function __construct(Request  $request)
    {
        $this->request = $request ;
        $this->systemDefaultLanguage = (int) options(EnumsOption::SYSTEM_DEFAULT_LANGUAGE);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = true ;

        $languages = array_keys($value) ;

        $countLangs = app(LanguageRepository::class)->query()->whereIn("id" , $languages)->count() ;

        if($countLangs !== count($languages)) {

            $this->message = trans("dashboard.error.validation.language.not_equal_count") ;

            $result = false ;

        }

//        if(! in_array($this->systemDefaultLanguage , $languages))
//        {
//            $this->message = trans("dashboard.error.validation.language.not_found_default_lang") ;
//            $result = false ;
//        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message ;
    }
}
