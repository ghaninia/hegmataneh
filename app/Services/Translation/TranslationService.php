<?php

namespace App\Services\Translation;

use App\Core\Interfaces\TranslationableInterface;
use App\Repositories\Translation\TranslationRepository;

class TranslationService implements TranslationServiceInterface
{
    protected $translationRepo;

    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepo = $translationRepo;
    }

    /**
     * @param TranslationableInterface $model
     * @param array $translations
     * @return void
     */
    public function sync(TranslationableInterface $model, array $translations): void
    {

        $fields = (array) $model->translationable;

        $model
            ->translations()
            ->delete();

        foreach ($translations as $language => $trans)
            foreach ($fields as $field)
                if (array_key_exists($field, $trans)) {
                    $instaces[] = [
                        "translationable_id" => $model->id,
                        "translationable_type" => $model->getMorphClass(),
                        "language_id" => $language,
                        "field" => $field,
                        "trans" => $trans[$field] ?? null
                    ];
                }

        $this->translationRepo->createMultiple($instaces);
    }
}
