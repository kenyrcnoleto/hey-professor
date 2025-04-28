<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

test('it should be able to uypdate a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('Updated Question?');
});

test('it should make sure that only question with status DRAFT can be update', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $draftQuestion    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft))
        ->assertForbidden();
    put(route('question.update', $draftQuestion), ['question' => 'Updated Question?'])
      ->assertRedirect();
});

test('it should make sure that only the person who create the question can update the question ', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    //Forbidden - não permitido a publicação pelo usuario errado
    put(route('question.update', $question))
        ->assertForbidden();

    actingAs($rightUser);

    put(route('question.update', $question), ['question' => 'Updated Question?'])
        ->assertRedirect();

});
