@extends('layouts.app')

@section('title', 'Buscar Entrega por CPF')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('tracking.index') }}" method="GET">
            <div class="mb-6">
                <label for="search_term" class="block mb-2 text-sm font-medium text-gray-900">
                    CPF do Destinatário
                </label>
                <input
                    type="text"
                    id="cpf"
                    name="cpf"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-4"
                    placeholder="Digite apenas os números do CPF"
                    required
                    value=""
                >
            </div>

            <button
                type="submit"
                class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors duration-200"
            >
                Buscar Entrega
            </button>
        </form>
    </div>

    <div class="max-w-4xl mx-auto">

        @if(isset($foundDeliveries) && $foundDeliveries->isNotEmpty())
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center sm:text-left">
                Entregas Encontradas
            </h2>

            <div class="space-y-6">
                @foreach ($foundDeliveries as $delivery)
                    <div class="bg-white rounded-xl shadow-lg border border-orange-200 overflow-hidden transition hover:shadow-xl hover:border-orange-300">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded-full text-orange-600 bg-orange-200">
                                        Entrega
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-2">
                                        ID: {{ substr($delivery->uuid, 0, 8) }}...
                                    </h3>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:text-right flex-shrink-0">
                                    @if($delivery->statuses->isNotEmpty())
                                        <p class="font-semibold text-gray-900">{{ $delivery->statuses->last()->message }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $delivery->statuses->last()->event_timestamp->format('d/m/Y H:i') }}
                                        </p>
                                    @else
                                        <p class="font-semibold text-gray-900">Status Indisponível</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                            <div>
                                <p class="text-gray-500 font-bold tracking-wide uppercase">Remetente</p>
                                <p class="text-gray-800 font-medium">{{ $delivery->sender->name ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-bold tracking-wide uppercase">Transportadora</p>
                                <p class="text-gray-800 font-medium">{{ $delivery->carrier->name ?? 'Não informada' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-bold tracking-wide uppercase">Volumes</p>
                                <p class="text-gray-800 font-medium">{{ $delivery->volumes }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 text-right">
                            <a href="{{ route('tracking.show', ['delivery' => $delivery->uuid]) }}"
                               class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition-colors duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800"
                            >
                                Ver Detalhes Completos
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        @elseif(request()->has('cpf'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg text-center" role="alert">
                <p class="font-bold">Nenhuma entrega encontrada</p>
                <p>Não encontramos registros para o CPF informado. Verifique o número e tente novamente.</p>
            </div>
        @endif
    </div>

@endsection
