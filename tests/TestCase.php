<?php

namespace Tests;

use Tests\Dependency\Traits\FreshSeedOnce;
use Tests\Dependency\Traits\ActingAsSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, FreshSeedOnce , ActingAsSystem;
}
