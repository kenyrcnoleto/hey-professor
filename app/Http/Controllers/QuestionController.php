<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
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
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    // dd($value[strlen($value)-1] != '?');
                    if ($value[strlen($value) - 1] != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end');
                    }
                }, ],
        ]);

        Question::query()->create($atributes);

        return to_route('dashboard');
    }
}
