<?php

namespace App\Services\Language;

use App\Core\Interfaces\LanguageableInterface;
use App\Models\Language;
use App\Core\Enums\EnumsLanguage;
use Illuminate\Contracts\Pagination\Paginator;
use App\Repositories\Language\LanguageRepository;
use App\Services\Language\LanguageServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LanguageService implements LanguageServiceInterface
{
    protected $languageRepo;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepo = $languageRepo;
    }

    /**
     * لیست زبان ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters , bool $isPaginate = true ): Paginator|Collection
    {
        return
            $this->languageRepo->query()
            ->filterBy($filters)
            ->when(
                $isPaginate ,
                fn($query) => $query->paginate() ,
                fn($query) => $query->get()
            );
    }

    /**
     * ساخت زبان جدید
     * @param array $data
     * @return Language
     */
    public function create(array $data): Language
    {
        return
            $this->languageRepo->create([
                "name" => $data["name"],
                "code" => $data["code"] ?? null ,
                "direction" => $data["direction"] ?? EnumsLanguage::DIRECTION_RTL
            ]);
    }

    /**
     * ویرایش زبان
     * @param Language $language
     * @param array $data
     * @return Language
     */
    public function update(Language $language, array $data): Language
    {
        return
            $this->languageRepo->updateById($language->id, [
                "name" => $data["name"],
                "code" => $data["code"] ?? null ,
                "direction" => $data["direction"] ?? EnumsLanguage::DIRECTION_RTL
            ]);
    }

    /**
     * حذف زبان
     * @param Language $language
     * @return boolean
     */
    public function delete(Language $language): bool
    {
        return $this->languageRepo->delete($language);
    }


}
