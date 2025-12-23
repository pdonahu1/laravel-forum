<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Illuminate\Http\Request;


use Inertia\Testing\AssertableInertia as Assert;

pest()
    ->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

pest()
    ->extend(TestCase::class)
    ->in('Unit');

// Custom Inertia assertion macros
TestResponse::macro('assertComponent', function (string $component) {
    return $this->assertInertia(fn (Assert $page) => $page->component($component));
});

TestResponse::macro('assertHasPaginatedResource', function (string $key, $resource) {
    return $this->assertInertia(function (Assert $page) use ($key, $resource) {
        $page->has($key . '.data')
             ->has($key . '.links');
        
        // Compare the data arrays
        $expected = $resource->toArray(request());
        $actual = $page->toArray()['props'][$key]['data'];
        
        expect($actual)->toEqual($expected);
    });

    TestResponse::macro('assertHasResource', function (string $key, $resource) {
    return $this->assertInertia(function (Assert $page) use ($key, $resource) {
        $page->has($key);
        
        $expected = $resource->toArray(request());
        $actual = $page->toArray()['props'][$key];
        
        expect($actual)->toEqual($expected);
    });
});
});