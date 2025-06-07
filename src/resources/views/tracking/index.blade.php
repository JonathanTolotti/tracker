@extends('layouts.app')

@section('title', 'Buscar Entrega por CPF')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('tracking.index') }}" method="GET">
            @csrf
            {{-- Campo de texto para o CPF --}}
            <div class="mb-6">
                <label for="search_term" class="block mb-2 text-sm font-medium text-gray-900">
                    CPF do Destinatário
                </label>
                <input
                    type="text"
                    id="search_term"
                    name="search_term"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-4"
                    placeholder="Digite apenas os números do CPF"
                    required
                    value="35595606088"
                >
            </div>

            <button
                type="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors duration-200"
            >
                Buscar Entrega
            </button>
        </form>
    </div>


    <div class="max-w-4xl mx-auto mt-12">
         @if(isset($deliveries) && $deliveries->count() > 0)

         @elseif(request()->has('search_term'))

         @endif
    </div>
@endsection
