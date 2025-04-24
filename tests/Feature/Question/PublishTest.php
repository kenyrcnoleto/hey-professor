<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

test('it should be able to publish a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    put(route('question.publish', $question))
        ->assertRedirect();

    //Precisa ir novamente no banco de dados e atualizar o model com os novos dados da consulta -
    $question->refresh();

    expect($question)
        ->draft->toBeFalse();

});

test('it should make sure that only the person who create the question can publish the question ', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    //Forbidden - não permitido a publicação pelo usuario errado
    put(route('question.publish', $question))
        ->assertForbidden();

    actingAs($rightUser);

    put(route('question.publish', $question))
        ->assertRedirect();

});
