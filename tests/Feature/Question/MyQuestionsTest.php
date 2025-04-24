<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

test('it should be able to list all questions created by me', function () {

    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory()->for($wrongUser, 'createdBy')->count(10)->create();

    $user = User::factory()->create();

    $questions = Question::factory()->for($user, 'createdBy')->count(10)->create();

    actingAs($user);

    $response = get(route('question.index'));

    //forma de travar a variável. Dessa forma Laravel sabe que é o model Question
    /** @var Question $q */
    foreach($questions as $q) {
        //verificar se cada pergunta está sendo respondida
        $response->assertSee($q->question);
    }
    //** @var Question $q */
    foreach($wrongQuestions as $q) {
        //verificar se cada pergunta está sendo respondida
        $response->assertDontSee($q->question);
    }
});
