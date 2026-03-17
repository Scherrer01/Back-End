```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Estoque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form action="{{ route('estoques.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">ID do Produto</label>
                        <input type="number" name="produto_id" value="{{ old('produto_id') }}"
                               class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Quantidade</label>
                        <input type="number" name="quantidade" value="{{ old('quantidade') }}"
                               class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('estoque.index') }}" class="mr-4 text-sm text-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Salvar Estoque
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
```
