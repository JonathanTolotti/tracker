@extends('layouts.app')

@section('title', 'Detalhes da Entrega')

@section('content')
    <section class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-3xl font-bold text-blue-800">Detalhes da Entrega</h2>
                <p class="text-sm text-gray-500 font-mono mt-1">ID: {{ $detailedDelivery->uuid }}</p>
            </div>
            <a href="{{ route('tracking.index') }}" class="mt-4 sm:mt-0 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg text-sm transition-colors">
                &laquo; Fazer Nova Busca
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10 mb-12 text-sm">
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2 border-b pb-1">Transportadora</h3>
                    <p><strong class="text-gray-500 w-20 inline-block">Nome:</strong> {{ $detailedDelivery->carrier->name ?? 'N/A' }}</p>
                    <p><strong class="text-gray-500 w-20 inline-block">CNPJ:</strong> {{ $detailedDelivery->carrier->cnpj ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2 border-b pb-1">Remetente</h3>
                    <p><strong class="text-gray-500 w-20 inline-block">Nome:</strong> {{ $detailedDelivery->sender->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2 border-b pb-1">Volumes</h3>
                    <p>{{ $detailedDelivery->volumes }} volume(s)</p>
                </div>
            </div>
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2 border-b pb-1">Destinatário</h3>
                    <p><strong class="text-gray-500 w-20 inline-block">Nome:</strong> {{ $detailedDelivery->recipient->name ?? 'N/A' }}</p>
                    <p><strong class="text-gray-500 w-20 inline-block">CPF:</strong> {{ $detailedDelivery->recipient->cpf ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2 border-b pb-1">Endereço de Entrega</h3>
                    @if($detailedDelivery->shippingAddress)
                        <p>{{ $detailedDelivery->shippingAddress->street }}</p>
                        <p>{{ $detailedDelivery->shippingAddress->state }}, {{ $detailedDelivery->shippingAddress->zip_code }}</p>
                        <p>{{ $detailedDelivery->shippingAddress->country }}</p>
                    @else
                        <p>Endereço não informado.</p>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-xl text-gray-800 mb-4">Histórico do Rastreamento</h3>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse ($detailedDelivery->statuses as $status)
                        <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">

                            <div>
                                <p class="font-semibold text-gray-800">{{ $status->message }}</p>
                            </div>

                            <div class="text-right flex-shrink-0 ml-4">
                                <p class="text-sm font-medium text-gray-700">{{ $status->event_timestamp->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $status->event_timestamp->format('H:i') }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-center text-gray-500">
                            Nenhum histórico de rastreamento disponível.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
@endsection
