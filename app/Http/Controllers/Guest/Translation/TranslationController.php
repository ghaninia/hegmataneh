<?php

namespace App\Http\Controllers\Guest\Translation;

use App\Http\Controllers\Controller;
use App\Services\Translation\TranslationServiceInterface;
use Illuminate\Http\Request;

class TranslationController extends Controller
{

    public function __construct(
        public TranslationServiceInterface $translationService
    )
    {
    }

    /**
     * get translations files
     * @param Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        return $this->translationService->getTranslations();
    }
}
