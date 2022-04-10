<?php

namespace Tests\Unit\Kernel\Filter\Stub ;

use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;

class StubModel extends Model {

    use HasFilterTrait ;

    public function register()
    {
        return [
                StubModel::class => "Tests\\Unit\\Kernel\\Filter\\Stub\\StubFilters" ,
            ][__CLASS__] ?? null;
    }

}
