<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

trait BaseTest
{
    use WithFaker;

    protected function route($route, $params = []) {
    	return route($route, $params);
    }

    protected function selfCreate($model) {
    	return factory(get_class(new $model()))->create();
    }
}
