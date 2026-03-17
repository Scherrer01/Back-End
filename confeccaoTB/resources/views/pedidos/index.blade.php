<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestão de Pedidos') }}
            </h2>

            <a href="{{ route('pedidos.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                + Novo Pedido
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
                           id="buscaPedido"
                           placeholder="Buscar pedido..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Total: {{ $pedidos->count() }} pedidos
                    </span>
                    
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Total R$ {{ number_format($pedidos->sum('valor_total'), 2, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse ($pedidos as $pedido)
                        @php
                            // Formatação da quantidade com separador de milhares
                            $quantidadeFormatada = number_format($pedido->quantidade, 0, ',', '.');
                            
                            // Formatação do valor total
                            $valorTotalFormatado = 'R$ ' . number_format($pedido->valor_total, 2, ',', '.');
                            
                            // Data do pedido formatada
                            $dataPedido = $pedido->created_at ? $pedido->created_at->format('d/m/Y H:i') : null;
                            
                            // Nomes dos relacionamentos (assumindo que existem)
                            $nomeCliente = $pedido->cliente->nome ?? 'Cliente #' . $pedido->cliente_id;
                            $nomeProduto = $pedido->produto->nome ?? 'Produto #' . $pedido->produto_id;
                            
                            // Status do pedido (exemplo - você pode adaptar conforme seu sistema)
                            $status = $pedido->status ?? 'Em andamento';
                            $statusClasses = [
                                'Em andamento' => 'bg-yellow-100 text-yellow-800',
                                'Confirmado' => 'bg-blue-100 text-blue-800',
                                'Em preparação' => 'bg-purple-100 text-purple-800',
                                'Enviado' => 'bg-indigo-100 text-indigo-800',
                                'Entregue' => 'bg-green-100 text-green-800',
                                'Cancelado' => 'bg-red-100 text-red-800',
                            ];
                            $statusClasse = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
                            
                            // Valor unitário (se existir)
                            $valorUnitario = $pedido->quantidade > 0 ? $pedido->valor_total / $pedido->quantidade : 0;
                            $valorUnitarioFormatado = 'R$ ' . number_format($valorUnitario, 2, ',', '.');
                        @endphp

                        <div class="flex flex-col justify-between border border-gray-200 p-6 rounded-xl hover:shadow-2xl transition-all duration-300 bg-white hover:bg-gradient-to-br hover:from-white hover:to-indigo-50 transform hover:-translate-y-1">
                            
                            <!-- Cabeçalho com Status e Data -->
                            <div class="flex justify-between items-start mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasse }}">
                                    @switch($status)
                                        @case('Entregue')
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            @break
                                        @case('Cancelado')
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                    @endswitch
                                    {{ $status }}
                                </span>
                                
                                @if($dataPedido)
                                    <span class="text-xs text-gray-500" title="Data do pedido">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $dataPedido }}
                                    </span>
                                @endif
                            </div>

                            <!-- Número do Pedido -->
                            <div class="mb-4">
                                <span class="text-xs text-gray-500">Pedido</span>
                                <h3 class="font-bold text-2xl text-indigo-600">
                                    #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                            </div>

                            <!-- Informações do Cliente e Produto -->
                            <div class="space-y-3">
                                <!-- Cliente -->
                                <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500">Cliente</p>
                                        <p class="text-sm font-medium text-gray-800 truncate" title="{{ $nomeCliente }}">
                                            {{ $nomeCliente }}
                                        </p>
                                        <p class="text-xs text-gray-500">ID: #{{ str_pad($pedido->cliente_id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>

                                <!-- Produto -->
                                <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500">Produto</p>
                                        <p class="text-sm font-medium text-gray-800 truncate" title="{{ $nomeProduto }}">
                                            {{ $nomeProduto }}
                                        </p>
                                        <p class="text-xs text-gray-500">ID: #{{ str_pad($pedido->produto_id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalhes do Pedido -->
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <!-- Quantidade -->
                                <div class="bg-indigo-50 p-3 rounded-lg text-center">
                                    <span class="text-xs text-indigo-500">Quantidade</span>
                                    <p class="text-lg font-bold text-indigo-700">{{ $quantidadeFormatada }}</p>
                                    <p class="text-xs text-indigo-500">unidades</p>
                                </div>

                                <!-- Valor Unitário -->
                                <div class="bg-green-50 p-3 rounded-lg text-center">
                                    <span class="text-xs text-green-500">Valor Unit.</span>
                                    <p class="text-lg font-bold text-green-700">{{ $valorUnitarioFormatado }}</p>
                                    <p class="text-xs text-green-500">por unidade</p>
                                </div>
                            </div>

                            <!-- Valor Total -->
                            <div class="mt-4 bg-gradient-to-r from-indigo-500 to-purple-600 p-4 rounded-lg text-white">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm opacity-90">Valor Total</span>
                                    <span class="text-2xl font-bold">{{ $valorTotalFormatado }}</span>
                                </div>
                            </div>

                            <!-- Rodapé do card -->
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-indigo-50 text-indigo-600 text-sm font-medium rounded-lg hover:bg-indigo-100 transition duration-150 ease-in-out group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>

                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-excluir inline-flex items-center px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition duration-150 ease-in-out group"
                                            data-pedido="{{ '#'.str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}"
                                            data-cliente="{{ $nomeCliente }}"
                                            data-valor="{{ $valorTotalFormatado }}"
                                            data-id="{{ $pedido->id }}">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum pedido cadastrado</h3>
                            <p class="text-gray-500 mb-6">Comece cadastrando seu primeiro pedido.</p>
                            <a href="{{ route('pedidos.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Novo Pedido
                            </a>
                        </div>
                    @endforelse

                </div>

                <!-- Paginação (se existir) -->
                @if(method_exists($pedidos, 'links'))
                    <div class="mt-8">
                        {{ $pedidos->links() }}
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
                        Tem certeza que deseja excluir este pedido?
                    </p>
                    <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm space-y-2">
                        <p class="text-base font-bold text-indigo-600" id="pedidoModal">
                            Carregando...
                        </p>
                        <p class="text-sm text-gray-600" id="clienteModal">
                            ...
                        </p>
                        <p class="text-sm font-semibold text-green-600" id="valorModal">
                            ...
                        </p>
                    </div>
                    <p class="text-xs text-red-500 mt-3 font-medium">
                        ⚠️ Esta ação não poderá ser desfeita. Todos os dados do pedido serão permanentemente removidos.
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
        const pedidoModal = document.getElementById('pedidoModal');
        const clienteModal = document.getElementById('clienteModal');
        const valorModal = document.getElementById('valorModal');
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
                const pedido = this.getAttribute('data-pedido') || 'este pedido';
                const cliente = this.getAttribute('data-cliente') || 'Cliente não informado';
                const valor = this.getAttribute('data-valor') || 'R$ 0,00';
                const id = this.getAttribute('data-id') || '';
                
                // Atualiza o modal
                formExclusao.setAttribute('action', action);
                pedidoModal.textContent = pedido;
                clienteModal.textContent = `Cliente: ${cliente}`;
                valorModal.textContent = `Valor: ${valor}`;
                
                // Mostra o modal
                modal.classList.remove('hidden');
                modalAberto = true;
            });
        });

        // Sistema de busca em tempo real
        const buscaInput = document.getElementById('buscaPedido');
        if (buscaInput) {
            buscaInput.addEventListener('keyup', function() {
                const termo = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.grid > .border');
                let contadorVisiveis = 0;
                
                cards.forEach(card => {
                    const pedidoNum = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    const cliente = card.querySelector('.text-gray-800')?.textContent.toLowerCase() || '';
                    const valor = card.querySelector('.text-2xl.font-bold')?.textContent.toLowerCase() || '';
                    
                    if (pedidoNum.includes(termo) || cliente.includes(termo) || valor.includes(termo)) {
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
                    const totalOriginal = <?php echo $pedidos->count(); ?>;
                    if (termo === '') {
                        contadorElement.textContent = `Total: ${totalOriginal} pedidos`;
                    } else {
                        contadorElement.textContent = `Encontrados: ${contadorVisiveis} de ${totalOriginal} pedidos`;
                    }
                }
            });
        }
    });
    </script>

</x-app-layout>