<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, assertNotSoftDeleted, assertSoftDeleted, patch, put};

test('it should be ble to archive a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    patch(route('question.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

test('it should make sure that only the person who create the question can archive the question ', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    //Forbidden - não permitido a publicação pelo usuario errado
    patch(route('question.archive', $question))
        ->assertForbidden();

    actingAs($rightUser);

    patch(route('question.archive', $question))
        ->assertRedirect();

});

test('it should be able to restore a archive question', function () {
    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true, 'deleted_at' => now()]);

    actingAs($user);

    //Forma de encontrar o erro no dia a dia - salvar dentro de uma variável e colocar um dd.

    patch(route('question.restore', $question))
         ->assertRedirect();
    //dd($response);

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->toBeNull();
});
