<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

test('it should be able to publish a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => true]);

    actingAs($user);

    put(route('question.publish', $question))
        ->assertRedirect();

    //Precisa ir novamente no banco de dados e atualizar o model com os novos dados da consulta -
    $question->refresh();

    expect($question)
        ->draft->toBeFalse();

});
