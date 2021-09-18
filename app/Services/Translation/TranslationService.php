<?php

namespace App\Services\Translation;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Translation\TranslationRepository;
use App\Services\Translation\TranslationServiceInterface;

class TranslationService implements TranslationServiceInterface
{
    protected $translationRepo;

    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepo = $translationRepo;
    }

    /**
     * ساخت یک فایل ترجمه جدید
     * @param Language $language
     * @param Model $translationable
     * @param string $field
     * @param string|null $translate
     * @return TranslationRepository
     */
    public function create(
        Language $language,
        Model $translationable,
        string $field,
        ?string $translate = null
    ) {
        return
            $this->translationRepo->updateOrCreate([
                "translationable_id" => $translationable->id,
                "translationable_type" => $translationable->getMorphClass(),
                "language_id" => $language->id,
                "field" => $field
            ], [
                "translate" => $translate
            ]);
    }
}
