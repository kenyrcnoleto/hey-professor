<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    //__invoke é a forma de simplificar a chamada da rota sem ter que passar o nome do único método que existe
    public function __invoke(): View
    {
        //posso chamar a view e passar parâmetros. Será uma variável dentro da minha view
        return view('dashboard', [
            'questions' => Question::withSum('votes', 'like')
                        ->withSum('votes', 'unlike')
                        ->paginate(5),
        ]);
    }

}
