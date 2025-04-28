<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

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

test('it should make sure that only question with status DRAFT can be updated', function () {
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

//use function Pest\Laravel\assertDatabaseCount;
it('should be able to update a new question bigger than 255 characters', function () {
    //Arange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);

    actingAs($user);

    //Act :: agir

    $request = put(route('question.update', $question), [
        'question' => str_repeat(string: '*', times: 260) . '?',
    ]);

    //Asert :: verificar
    $request->assertRedirect();

    assertDatabaseCount(table: 'questions', count: 1);

    $this->assertDatabaseHas('questions', ['question' => str_repeat(string: '*', times: 260) . '?', ]);

})->todo();

it('should check if ends with question mark?', function () {
    //Arange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    //Act :: agir

    $request = put(route('question.update', $question), [
        'question' => str_repeat(string: '*', times: 10),

    ]);

    //Asert :: verificar
    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end',
    ]);

    //$question->refresh();

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);

    //$this->assertDatabaseCount(table: 'questions', count: 0);

});

it('should have at least 10 characters', function () {
    //Arange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    //Act :: agir

    $request = put(route('question.update', $question), [
        'question' => str_repeat(string: '*', times: 8) . '?',

    ]);

    //Asert :: verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);

});
