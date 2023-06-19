<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        // dd(request()->question);

        //  $question  = new Question();
        //  $question->question = request()->question;
        //  $question->save();

        $atributes = request()->validate([
            'question' => ['required', 'min:10'],
        ]);

        Question::query()->create($atributes);

        return to_route('dashboard');
    }
}
