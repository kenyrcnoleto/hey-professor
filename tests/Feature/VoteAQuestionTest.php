<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post, put};

test('it should be able like question ', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create();

    actingAs($user);

    //laravel já sabe que $question é um model e vai passar o id por debaixo dos panos... o laravel busca através da função getRouteKey()

    // $route = route('question.like', 4);

    //dd($route);

    post(route('question.like', $question))
        ->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,

    ]);

    //Como seia a consulta no DB
    // SELECT * FROM votes WHERE question_id = ? AND like = 1 AND unlike = 0 AND user_id = ? EXISTS

});
