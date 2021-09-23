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

        ### when empty translations delete entity for it 
        ### when not empty , used array keys translations and delete different 
        $model->translations()->delete();
        $instances = [];

        foreach ($translations as $language => $trans)
            foreach ($fields as $field)
                if (array_key_exists($field, $trans)) {
                    $instances[] = [
                        "language_id" => $language,
                        "field" => $field,
                        "translationable_id" => $model->id,
                        "translationable_type" => $model->getMorphClass(),
                        "trans" => $trans[$field] ?? null
                    ];
                }

        app(TranslationRepository::class)->createMultiple($instances);
    }
}
