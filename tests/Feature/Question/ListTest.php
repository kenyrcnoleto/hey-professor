<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {

    //Arrange - Preparar
    //Criar algumas perguntas

    $user = User::factory()->create();

    $questions = Question::factory()->count(5)->create();

    //agir como o usuário, poderia ser o be também
    actingAs($user);

    //Act - Ação
    //Acessar a rota

    $response = get(route('dashboard'));

    //Assert  - Verificar
    //verificar se a lista de perguntas está sendo mostrada

    //forma de travar a variável. Dessa forma Laravel sabe que é o model Question
    /** @var Question $q */
    foreach($questions as $q) {
        //verificar se cada pergunta está sendo respondida
        $response->assertSee($q->question);
    }

    //php artisan test --dirty roda a apenas os arquivos em que está trabalhando. propriedade pest 2.0
});
