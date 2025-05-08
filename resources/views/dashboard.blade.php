<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>

    </x-slot>

    <x-container>

        <div class="dark: text-gray-400 space-y-4" >

            <form action=" {{ route('dashboard') }} " method="get" class=" flex space-x-2">
                @csrf

                {{-- <x-search-input name="search" value="{{ request()->search }}"> </x-search-input> --}}


                <x-text-input type="text" name="search" value="{{ request()->search }}" class="w-full" />

                <x-btn.primary type="submit" >Search</x-btn.primary>
            </form>

            @if($questions->isNotEmpty())
                @foreach ($questions as $item)

                <x-question :question=$item />

                @endforeach
            @else
                <div class="dark:text-gray-300 text-center flex flex-col justify-center">
                    <div class="justify-center flex">

                        <x-draw.searching width="300" height="300"/>
                    </div>

                    <div class="mt-6 dark:text-gray-400 font-bold text-2xl ">
                        Question not found
                    </div>
                </div>

            @endif

            {{ $questions->withQueryString()->links() }}
        </div>
    </x-container>


    {{-- Posso passar parâmetro para o blade  --}}
    {{-- proprieedate. colocando : entende que é um código php, mas precisa colocar as   '' --}}
    {{-- Existe essas 3 possibilidade de passar informações para as propriedades dos componentes --}}
    {{-- <x-teste param1="oi">
                <x-slot:title>
                    <div class="text-blue-400">MEU TITULO AZUL</div>
                </x-slot:title>
                testeteee
            </x-teste>
            <x-teste title="diferent"/>
            <x-teste  title="legal" />
            <x-teste  title="show" />
            <x-teste  title="mais um teste" /> --}}


</x-app-layout>
