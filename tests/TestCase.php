<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Mock an instance of an object (dummy) in the container.
     *
     * @param string $abstract
     *
     * @see InteractsWithContainer::mock()
     */
    protected function dummy(string $abstract)
    {
        $stubInstance = $this->createStub($abstract);
        $this->app->instance($abstract, $stubInstance);
    }
}
