
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pedidos') }}
            </h2>

            <a href="{{ route('pedidos.create') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                + Novo Pedido
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse ($Pedidos as $pedido)

                        <div class="border p-5 rounded-lg bg-gray-50 hover:shadow-lg transition">

                            <h3 class="font-bold text-lg mb-2">
                                Pedido #{{ $pedido->id }}
                            </h3>

                            <p class="text-sm text-gray-600">
                                <strong>Cliente ID:</strong> {{ $pedido->cliente_id }}
                            </p>

                            <p class="text-sm text-gray-600">
                                <strong>Produto ID:</strong> {{ $pedido->produto_id }}
                            </p>

                            <p class="text-sm text-indigo-600">
                                📦 Quantidade: {{ $pedido->quantidade }}
                            </p>

                            <p class="text-sm text-green-600 font-semibold">
                                💰 R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}
                            </p>

                        </div>

                    @empty

                        <div class="col-span-full text-center py-10 text-gray-400">
                            Nenhum pedido cadastrado.
                        </div>

                    @endforelse

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
