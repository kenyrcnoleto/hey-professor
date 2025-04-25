<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('it should be albe to open a question to edit', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    get(route('question.edit', $question))
        ->assertSuccessful();

});

test('it should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    get(route('question.edit', $question))
        ->assertViewIs('question.edit');

});
