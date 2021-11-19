<?php

namespace Tests\Unit\Core;

use Exception;
use Tests\TestCase;
use Illuminate\Support\Collection;
use App\Core\Traits\HasFilterTrait;

class FilterBuilderTest extends TestCase
{
    public function test_it_can_build_a_filter()
    {
        // $stub = $this->getMockForTrait(HasFilterTrait::class);
        // $registers = $stub->locationFilters();

        // foreach ($registers as $model => $namespace) {

        //     $files = glob($namespace . DIRECTORY_SEPARATOR . "*");

        //     $filters = [];

        //     array_walk($files, function ($file) use (&$filters) {
        //         $filters[basename($file, ".php")] = NULL;
        //     });

        //     $result = $model::filterBy($filters)->get();
        // }

        // $this->assertInstanceOf(Collection::class, $result);
    }
}
