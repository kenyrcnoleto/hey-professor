<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get, withoutExceptionHandling};

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

test('it should paginate result', function () {

    $user = User::factory()->create();

    $questions = Question::factory()->count(1)->create();

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas(
            'questions',
            fn ($value) => $value instanceof LengthAwarePaginator
        );

});

test('it should order by like and unlike, most liked question should be at the top, mos unlike question should be in the bottom', function () {
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();

    $questions = Question::factory()->count(5)->create();

    //Sempre quer ter clareza no momento dos testes - por isso foi modificado estes itens abaixo:
    //$mostLikedQuestion = Question::inRandomOrder()->first();
    //$mostUnlikedQuestion = Question::where('id', '!=', $mostLikedQuestion)->first();
    //remove function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) -- $mostUnlikedQuestion->id

    $mostLikedQuestion   = Question::find(3);
    $mostUnlikedQuestion = Question::find(1);

    $user->like($mostLikedQuestion);
    $secondUser->unlike($mostUnlikedQuestion);

    //Chamar esta função caso não esteja entendendo o motivo do erro no momento do teste.
    // withoutExceptionHandling();

    actingAs($user);

    get(route('dashboard'))
    ->assertViewHas('questions', function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) {

        //dd($questions->toArray());
        expect($questions)->first()->id->toBe(3)
            ->and($questions)
            ->last()->id->toBe(1);

        return true;
    });
});
