<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('iit should be able to search a question by text', function () {
    //Criar algumas perguntas

    $user = User::factory()->create();

    $wrongQuestion = Question::factory()->create(['question' => 'Something else?']);

    $question = Question::factory()->create(['question' => 'My question is?']);

    //agir como o usuário, poderia ser o be também

    actingAs($user);

    //Act - Ação
    //Acessar a rota

    $response = get(route('dashboard', ['search' => 'question']));

    //Assert  - Verificar
    //verificar se a lista de perguntas está sendo mostrada

    $response->assertDontSee(['Something else?']);

    $response->assertSee(('My question is?'));
});
