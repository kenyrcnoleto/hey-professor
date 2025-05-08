<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    //__invoke é a forma de simplificar a chamada da rota sem ter que passar o nome do único método que existe
    public function __invoke(): View
    {
        //dd(request()->all());
        //posso chamar a view e passar parâmetros. Será uma variável dentro da minha view
        return view('dashboard', [
            'questions' => Question::query()
                        ->when(request()->has('search'), function (Builder $query) {
                            $query->where('question', 'like', '%' . request()->search . '%');
                        })
                        ->withSum('votes', 'like')
                        ->withSum('votes', 'unlike')
                        ->orderByRaw('case when votes_sum_like is null then 0 else votes_sum_like end desc,
                                case when votes_sum_like is null then 0 else votes_sum_unlike end ')
                        ->paginate(5),
        ]);
    }

}
