<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nossos Fornecedores</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-4">
                    <a href="{{ route('fornecedores.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Novo Fornecedor
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($fornecedores as $fornecedor)
                        <div class="border p-4 rounded shadow-sm hover:shadow-lg transition">
                            <h3 class="font-bold text-lg">{{ $fornecedor->nome }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <span class="font-semibold">CNPJ:</span> {{ $fornecedor->cnpj }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Email:</span> {{ $fornecedor->email }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Telefone:</span> {{ $fornecedor->telefone ?? 'Não informado' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Responsável:</span> {{ $fornecedor->responsavel ?? 'Não informado' }}
                            </p>
                            
                            <div class="mt-3 flex justify-end space-x-2">
                                <a href="{{ route('fornecedores.show', $fornecedor->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">Ver</a>
                                <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Editar</a>
                                <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            Nenhum fornecedor encontrado.
                            <a href="{{ route('fornecedores.create') }}" class="text-blue-500 hover:underline block mt-2">
                                Cadastrar primeiro fornecedor
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>