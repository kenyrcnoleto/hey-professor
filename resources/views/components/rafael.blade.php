@props([

    'title' => 'Título padrão',
    'param1' => null,

    ])

<div class="bg-white mt-2 rounded">
    @if($param1)
    Opa! tenho o parametro 1.
    @endif
    <div class="text-black  font-bold uppercase p-px text-xs">

        {{ $title }}

    </div>

    <div class="text-lg text-red-600 font-bold bg-red-50 p-4 border-2 border-red-300 rounded">

        {{-- Sempre vem implícito em todos os blades components $slot --}}
        {{$slot}}

    </div>
</div>
