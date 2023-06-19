<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

//use function Pest\Laravel\assertDatabaseCount;
it('should be able to create a new question bigger than 255 characters', function () {
    //Arange :: preparar
    $user = User::factory()->create();

    actingAs($user);

    //Act :: agir

    $request = post(route(name: 'question.store'), [
        'question'    => str_repeat(string: '*', times: 260) . '?',
        'outro_campo' => 'teste',
    ]);

    //Asert :: verificar
    $request->assertRedirect(route(name: 'dashboard'));

    $this->assertDatabaseCount(table: 'questions', count: 1);

    $this->assertDatabaseHas('questions', ['question' => str_repeat(string: '*', times: 260) . '?', ]);

});

it('should check if ends with question mark?', function () {
    //Arange :: preparar
    $user = User::factory()->create();

    actingAs($user);

    //Act :: agir

    $request = post(route(name: 'question.store'), [
        'question' => str_repeat(string: '*', times: 10),

    ]);

    //Asert :: verificar
    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end',
    ]);

    $this->assertDatabaseCount(table: 'questions', count: 0);

});

it('should have at least 10 characters', function () {
    //Arange :: preparar
    $user = User::factory()->create();

    actingAs($user);

    //Act :: agir

    $request = post(route(name: 'question.store'), [
        'question' => str_repeat(string: '*', times: 8) . '?',

    ]);

    //Asert :: verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);

    $this->assertDatabaseCount(table: 'questions', count: 0);

    //  $this->assertDatabaseHas('questions', ['question' => str_repeat(string: '*', times: 8) . '?', ]);
});
