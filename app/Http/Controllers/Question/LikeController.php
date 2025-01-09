<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{Question, Vote};
use Illuminate\Http\{RedirectResponse, Request};

class LikeController extends Controller
{
    public function __invoke(
        Question $question
    ): RedirectResponse {

        //dd($question->toArray());
        Vote::query()->create([
            'question_id' => $question->id,
            'user_id'     => auth()->id(),
            'like'        => 1,
            'unlike'      => 0,

        ]);

        //Route Model Binding - link entre a rota e o model - dessa forma não precisa procurar no model novamente - procura por padrão findOrFail
        //$question = Question::find($question);
        //dd($question->toArray());
        return back();
    }
}
