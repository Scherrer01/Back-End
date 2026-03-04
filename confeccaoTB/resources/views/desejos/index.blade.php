<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Desejos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Botão para criar novo desejo -->
                <div class="mb-4">
                    <a href="{{ route('desejos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Novo Desejo
                    </a>
                </div>

                <!-- Grid de desejos -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($desejos as $desejo)
                        <div class="border p-4 rounded shadow-sm hover:shadow-lg transition">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">{{ $desejo->produto }}</h3>
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($desejo->status == 'pendente') bg-yellow-100 text-yellow-800
                                    @elseif($desejo->status == 'em_andamento') bg-blue-100 text-blue-800
                                    @elseif($desejo->status == 'concluido') bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($desejo->status) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mt-2">
                                <span class="font-semibold">Cliente:</span> {{ $desejo->cliente->nome ?? 'Não informado' }}
                            </p>
                            
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Quantidade:</span> {{ $desejo->quantidade }}
                            </p>
                            
                            <p class="text-lg text-blue-600 font-bold mt-2">
                                R$ {{ number_format($desejo->valor, 2, ',', '.') }}
                            </p>
                            
                            <div class="mt-3 flex justify-end space-x-2">
                                <a href="{{ route('desejos.show', $desejo->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">Ver</a>
                                <a href="{{ route('desejos.edit', $desejo->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Editar</a>
                                <form action="{{ route('desejos.destroy', $desejo->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Tem certeza que deseja excluir este desejo?')">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            Nenhum desejo encontrado.
                            <a href="{{ route('desejos.create') }}" class="text-blue-500 hover:underline block mt-2">
                                Criar primeiro desejo
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>