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

        ### when empty translations delete entity for it 
        ### when not empty , used array keys translations and delete different 
        $model->translations()->when(
            $isEmpty = empty($translations),
            function ($query) {
                $query->delete();
            },
            function ($query) use ($translations) {
                $query->whereNotIn("id", array_keys($translations))->delete();
            }
        );

        if ($isEmpty) return;

        array_walk($translations, function ($trans, $language) use ($model) {

            $fields = $model->translationable;

            foreach ($fields as $field) {

                if (array_key_exists($field, $trans)) {
                    $this->translationRepo->updateOrCreate([
                        "language_id" => $language,
                        "field" => $field,
                        "translationable_id" => $model->id,
                        "translationable_type" => $model->getMorphClass()
                    ], [
                        "trans" => $trans[$field] ?? null
                    ]);
                }
            }
        });
    }
}
