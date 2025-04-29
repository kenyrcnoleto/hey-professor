<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('it should be albe to open a question to edit', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))
        ->assertSuccessful();

});

test('it should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))
        ->assertViewIs('question.edit');

});

test('it should make sure that only question with status DRAFT can be edited', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $draftQuestion    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $questionNotDraft))
        ->assertForbidden();
    get(route('question.edit', $draftQuestion))
    ->assertSuccessful();
});

test('it should make sure that only the person who create the question can edit the question ', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    //Forbidden - não permitido a publicação pelo usuario errado
    get(route('question.edit', $question))
        ->assertForbidden();

    actingAs($rightUser);

    get(route('question.edit', $question))
        ->assertSuccessful();

});
