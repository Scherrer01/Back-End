<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catálogo de Produtos') }}
            </h2>
            <a href="{{ route('produtos.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                + Novo Produto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensagem de Sucesso -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r flex items-center animate-slideIn">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
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
                           id="buscaProduto"
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
                        Total: {{ $Produtos->count() }} produtos
                    </span>
                    
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Estoque Total: {{ number_format($Produtos->sum('quantidade'), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    @forelse ($Produtos as $produto)
                        @php
                            // Formatação do preço
                            $precoFormatado = 'R$ ' . number_format($produto->preco, 2, ',', '.');
                            
                            // Formatação da quantidade com separador de milhares
                            $quantidadeFormatada = number_format($produto->quantidade, 0, ',', '.');
                            
                            // Determina a classe de cor baseada na quantidade em estoque
                            $estoqueClasse = 'text-green-600';
                            $estoqueBgClasse = 'bg-green-50';
                            $badgeEstoque = 'Estoque OK';
                            
                            if ($produto->quantidade <= 5) {
                                $estoqueClasse = 'text-red-600';
                                $estoqueBgClasse = 'bg-red-50';
                                $badgeEstoque = 'Estoque Crítico';
                            } elseif ($produto->quantidade <= 15) {
                                $estoqueClasse = 'text-yellow-600';
                                $estoqueBgClasse = 'bg-yellow-50';
                                $badgeEstoque = 'Estoque Médio';
                            }
                            
                            // Primeira letra do nome para o avatar
                            $iniciais = strtoupper(substr($produto->nome, 0, 1));
                            
                            // Cor aleatória baseada no ID do produto
                            $cores = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-orange-500'];
                            $indiceCor = crc32($produto->id) % count($cores);
                            $corAvatar = $cores[$indiceCor];
                            
                            // Data de cadastro formatada
                            $dataCadastro = $produto->created_at ? $produto->created_at->format('d/m/Y') : null;
                            
                            // Truncar descrição longa
                            $descricaoCurta = Str::limit($produto->descricao, 60);
                        @endphp

                        <div class="flex flex-col justify-between border border-gray-200 p-6 rounded-xl hover:shadow-2xl transition-all duration-300 bg-white hover:bg-gradient-to-br hover:from-white hover:to-indigo-50 transform hover:-translate-y-1">
                            
                            <!-- Badge de Estoque e Data -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $estoqueBgClasse }} {{ $estoqueClasse }}">
                                    @if($produto->quantidade <= 5)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    @elseif($produto->quantidade <= 15)
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                    {{ $badgeEstoque }}
                                </span>
                                
                                @if($dataCadastro)
                                    <span class="text-xs text-gray-500" title="Data de cadastro">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $dataCadastro }}
                                    </span>
                                @endif
                            </div>

                            <!-- Cabeçalho com Avatar -->
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 {{ $corAvatar }} rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                                        {{ $iniciais }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-xl text-gray-900 truncate hover:text-indigo-600 transition" title="{{ $produto->nome }}">
                                        {{ $produto->nome }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        ID: #{{ str_pad($produto->id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Descrição</p>
                                <p class="text-sm text-gray-700" title="{{ $produto->descricao }}">
                                    {{ $descricaoCurta }}
                                </p>
                            </div>

                            <!-- Informações de Preço e Estoque -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <!-- Preço -->
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-3 rounded-lg text-center border border-green-100">
                                    <svg class="w-5 h-5 text-green-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500">Preço</span>
                                    <p class="text-lg font-bold text-green-700">{{ $precoFormatado }}</p>
                                </div>

                                <!-- Estoque -->
                                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-3 rounded-lg text-center border border-indigo-100">
                                    <svg class="w-5 h-5 text-indigo-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span class="text-xs text-gray-500">Estoque</span>
                                    <p class="text-lg font-bold {{ $estoqueClasse }}">{{ $quantidadeFormatada }}</p>
                                    <p class="text-xs text-gray-500">unidades</p>
                                </div>
                            </div>

                            <!-- Barra de progresso do estoque (opcional) -->
                            @php
                                $estoqueMaximo = 50; // Valor máximo de referência
                                $percentual = min(100, ($produto->quantidade / $estoqueMaximo) * 100);
                            @endphp
                            
                            <div class="mt-2 mb-4">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Nível de Estoque</span>
                                    <span>{{ number_format($percentual, 0) }}%</span>
                                </div>
                                <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-200">
                                    <div style="width: <?php echo $percentual; ?>%;" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center <?php echo $estoqueBgClasse; ?> <?php echo $estoqueClasse; ?> bg-opacity-50 rounded-full">
                                    </div>
                                </div>
                            </div>

                            <!-- Rodapé do card -->
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('produtos.edit', $produto->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-indigo-50 text-indigo-600 text-sm font-medium rounded-lg hover:bg-indigo-100 transition duration-150 ease-in-out group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>

                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-excluir inline-flex items-center px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition duration-150 ease-in-out group"
                                            data-produto="{{ $produto->nome }}"
                                            data-preco="{{ $precoFormatado }}"
                                            data-estoque="{{ $quantidadeFormatada }}"
                                            data-id="{{ $produto->id }}">
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
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto cadastrado</h3>
                            <p class="text-gray-500 mb-6">Comece cadastrando seu primeiro produto no catálogo.</p>
                            <a href="{{ route('produtos.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Novo Produto
                            </a>
                        </div>
                    @endforelse

                </div>

                <!-- Paginação (se existir) -->
                @if(method_exists($Produtos, 'links'))
                    <div class="mt-8">
                        {{ $Produtos->links() }}
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
                        Tem certeza que deseja excluir este produto?
                    </p>
                    <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm space-y-2">
                        <p class="text-base font-bold text-indigo-600" id="produtoModal">
                            Carregando...
                        </p>
                        <p class="text-sm text-gray-600" id="precoModal">
                            ...
                        </p>
                        <p class="text-sm font-semibold" id="estoqueModal">
                            ...
                        </p>
                    </div>
                    <p class="text-xs text-red-500 mt-3 font-medium">
                        ⚠️ Esta ação não poderá ser desfeita. Todos os dados do produto serão permanentemente removidos.
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

        /* Efeito de fade para busca */
        .card-hidden {
            display: none;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.3s ease;
        }

        .card-visible {
            display: flex;
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuração do Modal
        const modal = document.getElementById('modalConfirmacao');
        const formExclusao = document.getElementById('formExclusao');
        const produtoModal = document.getElementById('produtoModal');
        const precoModal = document.getElementById('precoModal');
        const estoqueModal = document.getElementById('estoqueModal');
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
                const preco = this.getAttribute('data-preco') || 'R$ 0,00';
                const estoque = this.getAttribute('data-estoque') || '0';
                const id = this.getAttribute('data-id') || '';
                
                // Atualiza o modal
                formExclusao.setAttribute('action', action);
                produtoModal.textContent = produto;
                precoModal.textContent = `Preço: ${preco}`;
                estoqueModal.textContent = `Estoque: ${estoque} unidades`;
                
                // Mostra o modal
                modal.classList.remove('hidden');
                modalAberto = true;
            });
        });

        // Sistema de busca em tempo real
        const buscaInput = document.getElementById('buscaProduto');
        if (buscaInput) {
            buscaInput.addEventListener('keyup', function() {
                const termo = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.grid > .border');
                let contadorVisiveis = 0;
                
                cards.forEach(card => {
                    const nome = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    const descricao = card.querySelector('.text-gray-700')?.textContent.toLowerCase() || '';
                    const preco = card.querySelector('.text-green-700')?.textContent.toLowerCase() || '';
                    
                    if (nome.includes(termo) || descricao.includes(termo) || preco.includes(termo)) {
                        card.style.display = 'flex';
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                        contadorVisiveis++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Atualiza contador de resultados
                const contadorElement = document.querySelector('.bg-gray-100 span');
                if (contadorElement) {
                    const totalOriginal = <?php echo $Produtos->count(); ?>;
                    if (termo === '') {
                        contadorElement.textContent = `Total: ${totalOriginal} produtos`;
                    } else {
                        contadorElement.textContent = `Encontrados: ${contadorVisiveis} de ${totalOriginal} produtos`;
                    }
                }
            });
        }
    });
    </script>

</x-app-layout>