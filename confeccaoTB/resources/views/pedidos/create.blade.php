```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">ID do Cliente</label>
                        <input type="number" name="cliente_id" value="{{ old('cliente_id') }}" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">ID do Produto</label>
                        <input type="number" name="produto_id" value="{{ old('produto_id') }}" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('produto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Quantidade</label>
                        <input type="number" name="quantidade" value="{{ old('quantidade') }}" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('quantidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Valor Total</label>
                        <input type="number" step="0.01" name="valor_total" value="{{ old('valor_total') }}" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" required>
                        @error('valor_total') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('pedidos.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>

                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Salvar Pedido
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
```
