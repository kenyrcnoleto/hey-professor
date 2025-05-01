<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Vote for a question') }}
        </x-header>

    </x-slot>

    <x-container>

        <div class="dark: text-gray-400 space-y-4" >
            @foreach ($questions as $item)

                <x-question :question=$item />

            @endforeach
            {{ $questions->links() }}
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
