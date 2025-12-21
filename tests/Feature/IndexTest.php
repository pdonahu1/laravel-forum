<?php

it('should return the correct component', function () {
        get(route('posts.index'))
            ->assertInertia(fn (AssertableInertia $inertia) => $inertia
                ->component('Posts/Index', true)
                
            );
    $this->markTestIncomplete('This test has not been implemented yet.');
});