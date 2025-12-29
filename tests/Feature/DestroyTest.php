<?php
use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
// use App\Providers\AuthServiceProvider;
// use function Pest\Laravel\assertModelMissing;



it('required authentication', function () {

    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});


it('can delete a comment', function () {

    $comment = Comment::factory()->create();

    actingAs($comment->user);

    delete(route('comments.destroy', $comment));

    $this->assertModelMissing($comment);
});

it('redirects to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)

    ->delete(route('comments.destroy', $comment))

    ->assertRedirect($comment->post->showRoute());
});

it('prevents you from deleting a comment you dont own', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())

    ->delete(route('comments.destroy', $comment))

    ->assertForbidden();

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
    ]);
});  // ← ADD THIS CLOSING!

it('prevents deleting a comment posted over an hour ago', function () {

    $this->freezeTime();
    $comment = Comment::factory()->create();
    $this->travel(1)->hours();

    actingAs($comment->user)
    ->delete(route('comments.destroy', $comment))
    ->assertForbidden();

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
    ]);
});

    it('redirects to the post show page with the correct page query parameter', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)

    ->delete(route('comments.destroy', ['comment' => $comment, 'page' => 2]))

    ->assertRedirect($comment->post->showRoute(['page' => 2]));
});

