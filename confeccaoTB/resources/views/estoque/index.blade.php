<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Controle de Estoque') }}
            </h2>

            <a href="{{ route('estoques.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                + Novo Registro
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r flex items-center animate-slideIn">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r flex items-center animate-slideIn">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filtros e Busca -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="relative w-full sm:w-64">
                    <input type="text" 
                           placeholder="Buscar produto..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Total: {{ $Estoques->count() }} itens
                    </span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <!-- Cards de Estoque -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse ($Estoques as $estoque)
                        @php
                            // Formatação da quantidade com separador de milhares
                            $quantidadeFormatada = number_format($estoque->quantidade, 0, ',', '.');
                            
                            // Determina a cor baseada na quantidade
                            $quantidadeClasse = 'text-green-600';
                            $quantidadeBgClasse = 'bg-green-50';
                            $iconeEstoque = 'check-circle';
                            
                            if ($estoque->quantidade <= 5) {
                                $quantidadeClasse = 'text-red-600';
                                $quantidadeBgClasse = 'bg-red-50';
                                $iconeEstoque = 'alert-triangle';
                            } elseif ($estoque->quantidade <= 15) {
                                $quantidadeClasse = 'text-yellow-600';
                                $quantidadeBgClasse = 'bg-yellow-50';
                                $iconeEstoque = 'alert-circle';
                            }
                            
                            // Data de atualização formatada (se existir)
                            $dataAtualizacao = isset($estoque->updated_at) ? $estoque->updated_at->format('d/m/Y H:i') : null;
                            
                            // Nome do produto (assumindo que existe relação com tabela produtos)
                            $nomeProduto = $estoque->produto->nome ?? 'Produto #' . $estoque->produto_id;
                            
                            // Calcula percentual para barra de progresso
                            $estoqueMaximo = 50; // Valor máximo de referência
                            $percentual = min(100, ($estoque->quantidade / $estoqueMaximo) * 100);
                            $estiloBarra = "width: {$percentual}%;";
                        @endphp

                        <div class="flex flex-col justify-between border border-gray-200 p-6 rounded-xl hover:shadow-2xl transition-all duration-300 bg-white hover:bg-gradient-to-br hover:from-white hover:to-indigo-50 transform hover:-translate-y-1">
                            
                            <!-- Status e Data -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $quantidadeBgClasse }} {{ $quantidadeClasse }}">
                                    @if($estoque->quantidade <= 5)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Estoque Crítico
                                    @elseif($estoque->quantidade <= 15)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Estoque Médio
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Estoque OK
                                    @endif
                                </span>
                                
                                @if($dataAtualizacao)
                                    <span class="text-xs text-gray-500" title="Última atualização">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $dataAtualizacao }}
                                    </span>
                                @endif
                            </div>

                            <!-- Cabeçalho do Card -->
                            <div class="flex items-start space-x-4">
                                <!-- Avatar/Ícone do Produto -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 {{ $quantidadeBgClasse }} rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 {{ $quantidadeClasse }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Informações do Produto -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900 mb-1">
                                        {{ $nomeProduto }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        ID: #{{ str_pad($estoque->produto_id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Informações de Estoque -->
                            <div class="mt-6 space-y-3">
                                <!-- Card de Quantidade com Destaque -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Quantidade em Estoque</span>
                                        <span class="text-2xl font-bold {{ $quantidadeClasse }}">
                                            {{ $quantidadeFormatada }}
                                        </span>
                                    </div>
                                    
                                    <!-- Barra de progresso do estoque -->
                                    <div class="mt-3 relative pt-1">
                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                            <div style="width: <?php echo $percentual; ?>%;" 
     class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center <?php echo $quantidadeBgClasse; ?> <?php echo $quantidadeClasse; ?> bg-opacity-50">
</div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>Mín: 0</span>
                                            <span>Máx: {{ $estoqueMaximo }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Adicionais -->
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="bg-gray-50 p-2 rounded-lg">
                                        <span class="text-gray-500">Entradas</span>
                                        <p class="font-semibold text-green-600">+{{ number_format($estoque->entradas ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-2 rounded-lg">
                                        <span class="text-gray-500">Saídas</span>
                                        <p class="font-semibold text-red-600">-{{ number_format($estoque->saidas ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rodapé do Card com Ações -->
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                                <a href="{{ route('estoques.edit', $estoque->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-indigo-50 text-indigo-600 text-sm font-medium rounded-lg hover:bg-indigo-100 transition duration-150 ease-in-out group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>

                                <form action="{{ route('estoques.destroy', $estoque->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-excluir inline-flex items-center px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition duration-150 ease-in-out group"
                                            data-produto="{{ $nomeProduto }}"
                                            data-quantidade="{{ $quantidadeFormatada }}"
                                            data-id="{{ $estoque->id }}">
                                        <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>

                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum registro encontrado</h3>
                            <p class="text-gray-500 mb-6">Comece cadastrando seu primeiro item no estoque.</p>
                            <a href="{{ route('estoques.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Novo Registro
                            </a>
                        </div>
                    @endforelse

                </div>

                <!-- Paginação (se existir) -->
                @if(method_exists($Estoques, 'links'))
                    <div class="mt-8">
                        {{ $Estoques->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão Melhorado -->
    <div id="modalConfirmacao" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden backdrop-blur-sm" style="z-index: 1000;">
        <div class="relative top-20 mx-auto p-8 border-0 w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-100">
            <div class="text-center">
                <!-- Ícone animado -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 animate-bounce">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mt-4">Confirmar Exclusão</h3>
                
                <div class="mt-4 px-4 py-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-3">
                        Tem certeza que deseja excluir este registro?
                    </p>
                    <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm space-y-2">
                        <p class="text-base font-bold text-indigo-600" id="produtoModal">
                            Carregando...
                        </p>
                        <p class="text-sm text-gray-600" id="quantidadeModal">
                            ...
                        </p>
                    </div>
                    <p class="text-xs text-red-500 mt-3 font-medium">
                        ⚠️ Esta ação não poderá ser desfeita. O registro será permanentemente removido.
                    </p>
                </div>
                
                <div class="flex justify-center space-x-4 mt-6">
                    <button id="cancelarExclusao" 
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-150 w-32">
                        Cancelar
                    </button>
                    
                    <form id="formExclusao" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-150 w-32 shadow-lg hover:shadow-xl">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animações suaves */
        .animate-slideIn {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Animações do modal */
        #modalConfirmacao {
            transition: opacity 0.3s ease-in-out;
        }

        #modalConfirmacao.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #modalConfirmacao.hidden > div {
            transform: scale(0.95);
            opacity: 0;
        }

        #modalConfirmacao > div {
            transform: scale(1);
            opacity: 1;
            transition: all 0.3s ease-in-out;
        }

        /* Efeitos hover */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Tooltip personalizado */
        [title] {
            position: relative;
            cursor: help;
        }

        [title]:hover:after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: #1f2937;
            color: white;
            font-size: 12px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalConfirmacao');
        const formExclusao = document.getElementById('formExclusao');
        const produtoModal = document.getElementById('produtoModal');
        const quantidadeModal = document.getElementById('quantidadeModal');
        const cancelarBtn = document.getElementById('cancelarExclusao');
        
        let modalAberto = false;
        
        // Fecha o modal quando clicar no botão cancelar
        cancelarBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            modalAberto = false;
        });
        
        // Fecha o modal quando clicar fora dele
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modalAberto = false;
            }
        });
        
        // Fecha o modal com a tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                modalAberto = false;
            }
        });
        
        // Intercepta todos os botões de exclusão
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (modalAberto) return;
                
                // Pega o formulário associado ao botão
                const form = this.closest('form');
                const action = form.getAttribute('action');
                
                // Pega os dados dos atributos data-
                const produto = this.getAttribute('data-produto') || 'este produto';
                const quantidade = this.getAttribute('data-quantidade') || '0';
                const id = this.getAttribute('data-id') || '';
                
                // Atualiza o modal
                formExclusao.setAttribute('action', action);
                produtoModal.textContent = produto;
                quantidadeModal.textContent = `Quantidade: ${quantidade} unidades`;
                
                // Mostra o modal
                modal.classList.remove('hidden');
                modalAberto = true;
            });
        });

        // Busca em tempo real
        const searchInput = document.querySelector('input[placeholder="Buscar produto..."]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const termo = this.value.toLowerCase();
                const cards = document.querySelectorAll('.grid > .border');
                
                cards.forEach(card => {
                    const titulo = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    if (titulo.includes(termo)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
    </script>

</x-app-layout>