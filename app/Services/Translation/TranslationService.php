<?php

namespace App\Services\Translation;

use App\Core\Interfaces\TranslationableInterface;
use App\Repositories\Translation\TranslationRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class TranslationService implements TranslationServiceInterface
{
    protected $translationRepo;

    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepo = $translationRepo;
    }

    public function getTranslations()
    {
        $translations = [];
        $langBasePath = resource_path("lang") ;
        $locatePath = glob($langBasePath . '/*');

        $includeFiles = [
            "dashboard"
        ];

        foreach ($locatePath as $locale) {
            $pathName = basename($locale);
            $files = collect(File::allFiles($locale)) ;

            ### filter files
            $files = $files->filter(function ($file) use ($includeFiles) {
                $fileName = basename($file->getPathname() , ".php");
                return in_array($fileName, $includeFiles);
            });

            ### get translations
            $translations[$pathName]  = $files->flatMap(function($file) use ($pathName){
                $baseName = basename($file->getPathname() , ".php");
                return [
                    $baseName => trans($baseName, [], $pathName)
                ];
            });
        }

        return $translations ;
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

        $instaces = [];

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
