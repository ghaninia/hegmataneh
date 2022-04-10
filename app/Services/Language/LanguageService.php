<?php

namespace App\Services\Language;

use App\Models\Language;
use App\Kernel\Enums\EnumsLanguage;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Language\LanguageServiceInterface;

class LanguageService implements LanguageServiceInterface
{

    /**
     * get languages list
     * @param array $filters
     * @param bool $isPaginate
     * @return Paginator|Collection
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
     * create or update language
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
     * update language
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
     * delete language
     * @param Language $language
     * @return bool
     */
    public function delete(Language $language): bool
    {
        return Language::whereId($language->id)->delete();
    }
}
