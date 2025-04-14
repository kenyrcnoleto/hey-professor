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

test('it should note be able to like more than 1 time', function () {
    $user = User::factory()->create();

    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));

    expect($user->votes()->where('question_id', '=', $question->id)->get())->toHaveCount(1);

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,

    ]);
});

test('it should be able unlike question ', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create();

    actingAs($user);

    //laravel já sabe que $question é um model e vai passar o id por debaixo dos panos... o laravel busca através da função getRouteKey()

    // $route = route('question.unlike', 4);

    //dd($route);

    post(route('question.unlike', $question))
        ->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,

    ]);

    //Como seia a consulta no DB
    // SELECT * FROM votes WHERE question_id = ? AND like = 1 AND unlike = 0 AND user_id = ? EXISTS

});

test('it should note be able to unlike more than 1 time', function () {
    $user = User::factory()->create();

    $question = Question::factory()->create();

    actingAs($user);

    post(route('question.unlike', $question));
    post(route('question.unlike', $question));
    post(route('question.unlike', $question));
    post(route('question.unlike', $question));

    expect($user->votes()->where('question_id', '=', $question->id)->get())->toHaveCount(1);

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,

    ]);
});
