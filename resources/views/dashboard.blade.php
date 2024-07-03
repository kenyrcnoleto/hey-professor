<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>

    </x-slot>

    <x-container>
        <x-form post :action="route('question.store')">

            <x-textarea label="Question" name="question" />

            <x-btn.primary>Save</x-button>

            <x-btn.reset>Cancel</x-btn.reset>

        </x-form>
    </x-container>


    {{-- Posso passar parâmetro para o blade  --}}
    {{-- proprieedate. colocando : entende que é um código php, mas precisa colocar as   '' --}}
    {{-- Existe essas 3 possibilidade de passar informações para as propriedades dos componentes --}}
    {{-- <x-rafael param1="oi">
                <x-slot:title>
                    <div class="text-blue-400">MEU TITULO AZUL</div>
                </x-slot:title>
                testeteee
            </x-rafael>
            <x-rafael title="diferent"/>
            <x-rafael  title="legal" />
            <x-rafael  title="show" />
            <x-rafael  title="mais um" /> --}}


</x-app-layout>
