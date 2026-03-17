<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Estoque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form action="{{ route('estoques.update', $estoque->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">ID do Produto</label>
                        <input type="number" name="produto_id" value="{{ old('produto_id', $estoque->produto_id) }}"
                               class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('produto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Quantidade</label>
                        <input type="number" name="quantidade" value="{{ old('quantidade', $estoque->quantidade) }}"
                               class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('quantidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('estoque.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Atualizar Estoque
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>