<?php

namespace App\Http\Controllers\Public\Translation;

use App\Http\Controllers\Controller;
use App\Services\Translation\TranslationService;
use Illuminate\Http\Request;

class TranslationController extends Controller
{

    public function __construct(public TranslationService $translationService)
    {
    }

    public function __invoke(Request $request)
    {
        return $this->translationService->getTranslations();
    }
}
