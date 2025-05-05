<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions'         => user()->questions,
            'archivedQuestions' => user()->questions()->onlyTrashed()->get(),
        ]);
    }
    public function store(): RedirectResponse
    {

        //dd(request()->all());

        //  $question  = new Question();
        //  $question->question = request()->question;
        //  $question->save();

        request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    // dd($value[strlen($value)-1] != '?');
                    if ($value[strlen($value) - 1] != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end');
                    }
                },
            ],
        ]);

        //Question::query()
        user()->questions()
            ->create([
                'question' => request()->question,
                'draft'    => true,
            ]);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    // dd($value[strlen($value)-1] != '?');
                    if ($value[strlen($value) - 1] != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end');
                    }
                },
            ],
        ]);

        $question->question = request()->question;

        $question->save();

        return to_route('question.index');

    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('archive', $question);

        $question->delete();

        return back();
    }

    public function restore(int $id): RedirectResponse
    {
        //Forma de encontrar qual rota que esta buscando e o método em que está caindo dd(__METHOD__);

        $question = Question::withTrashed()->find($id);

        $question->restore();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }
}
