<?php

namespace Tests\Unit\Kernel\Lazyloading;

use App\Kernel\Lazyloading\Lazyloading;
use PHPUnit\Framework\TestCase;

class LazyloadingTest extends TestCase
{

    /** @test */
    public function setConstrcutorPerPage()
    {
        $lazyloading = new Lazyloading(50) ;
        $this->assertSame($lazyloading->perPage , 50);
    }

}
