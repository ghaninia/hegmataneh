<?php

namespace Tests;

use Tests\Configuration\Traits\DatabaseRefreshOnlyOnce;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication , DatabaseRefreshOnlyOnce;
}
