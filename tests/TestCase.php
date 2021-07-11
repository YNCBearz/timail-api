<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Mock an instance (stub) of an object in the container.
     *
     * @param string $abstract
     * @return object
     *
     * @see InteractsWithContainer::mock()
     */
    protected function stub(string $abstract): object
    {
        $stubInstance = $this->createStub($abstract);
        return $this->app->instance($abstract, $stubInstance);
    }
}
