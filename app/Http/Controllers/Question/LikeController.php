<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{Question, User, Vote};
use Illuminate\Http\{RedirectResponse, Request};

class LikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {

        //Pelo fato do auth ser um contrato do tipo authenticable IDE não consegue buscar o método
        //direto no model. Forma de resolver

        /** @var User $user */
        $user = auth()->user();
        //$user->like($question);

        //Dessa forma facilita na hora de manutenção: auth()->user()->like($question);
        //Foi inserido uma função global
        user()->like($question);

        //Route Model Binding - link entre a rota e o model - dessa forma não precisa procurar no model novamente - procura por padrão findOrFail
        //$question = Question::find($question);
        //dd($question->toArray());
        return back();
    }
}
