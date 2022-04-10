<?php

namespace Tests\Unit\Kernel\Filter ;

use App\Kernel\DatabaseFilter\Exceptions\NotFoundModelForFilter;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\Unit\Kernel\Filter\Stub\StubModel;

class FilterTest extends TestCase
{
    /** @test */
    public function whenFilterNotExists()
    {
        $this->expectException( NotFoundModelForFilter::class );

        $query = StubModel::filterBy([
            "fieldName" => true
        ])->getQuery() ;

    }

    /** @test */
    public function boolFilter()
    {
        $result = Arr::first(
            StubModel::query()
                ->filterBy([
                    "field" => true
                ])
                ->getQuery()
                ->wheres
        ) ;

        $this->assertEquals($result["column"], "field" );
        $this->assertEquals($result["value"] , TRUE );

    }


}
