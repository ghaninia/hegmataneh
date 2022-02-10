<?php

namespace App\Services\Language;

use App\Models\Language;
use App\Core\Enums\EnumsLanguage;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Language\LanguageServiceInterface;

class LanguageService implements LanguageServiceInterface
{

    /**
     * لیست زبان ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters, bool $isPaginate = true): Paginator|Collection
    {
        return
            Language::query()
            ->filterBy($filters)
            ->when(
                $isPaginate,
                fn ($query) => $query->paginate(),
                fn ($query) => $query->get()
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
            Language::create([
                "name" => $data["name"],
                "code" => $data["code"] ?? null,
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
            Language::whereId($language->id)->update([
                "name" => $data["name"],
                "code" => $data["code"] ?? null,
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
        return Language::whereId($language->id)->delete();
    }
}
