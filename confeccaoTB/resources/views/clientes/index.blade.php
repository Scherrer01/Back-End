<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nossa Confecção') }}
            </h2>

            <a href="{{ route('cliente.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                + Novo Cliente
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @forelse ($Clientes as $cliente)
                        @php
                            // Formatação do CPF: 000.000.000-00
                            $cpfFormatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cliente->cpf);
                            
                            // Formatação do telefone: (00) 00000-0000
                            $telefone = preg_replace('/[^0-9]/', '', $cliente->telefone);
                            if (strlen($telefone) === 11) {
                                $telefoneFormatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
                            } else {
                                $telefoneFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
                            }
                            
                            // Capitalização do nome
                            $nomeFormatado = ucwords(strtolower($cliente->nome));
                            
                            // Data de cadastro formatada (se existir)
                            $dataCadastro = isset($cliente->created_at) ? $cliente->created_at->format('d/m/Y') : null;
                        @endphp

                        <div class="flex flex-col justify-between border border-gray-200 p-6 rounded-xl hover:shadow-2xl transition-all duration-300 bg-white hover:bg-gradient-to-br hover:from-white hover:to-indigo-50 transform hover:-translate-y-1">
                            <!-- Badge de data (opcional) -->
                            @if($dataCadastro)
                                <div class="text-right mb-2">
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-xs font-medium text-gray-600 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $dataCadastro }}
                                    </span>
                                </div>
                            @endif

                            <!-- Dados do cliente -->
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-indigo-600 font-bold text-lg">
                                                {{ strtoupper(substr($nomeFormatado, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="font-bold text-xl text-gray-900 mb-1 hover:text-indigo-600 transition">
                                            {{ $nomeFormatado }}
                                        </h3>
                                    </div>
                                </div>

                                <div class="space-y-2 mt-4">
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <span class="font-semibold text-gray-800 w-16">CPF:</span>
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-gray-700 font-mono text-sm">
                                            {{ $cpfFormatado }}
                                        </span>
                                    </p>

                                    <p class="text-sm flex items-center text-indigo-600 font-medium">
                                        <span class="font-semibold text-gray-800 w-16">Tel:</span>
                                        <span class="bg-indigo-50 px-3 py-1 rounded-full flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $telefoneFormatado }}
                                        </span>
                                    </p>

                                    <!-- Informação adicional: email (se existir) -->
                                    @if(isset($cliente->email) && $cliente->email)
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <span class="font-semibold text-gray-800 w-16">Email:</span>
                                            <span class="text-gray-600 truncate">{{ $cliente->email }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Rodapé do card -->
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-indigo-50 text-indigo-600 text-sm font-medium rounded-lg hover:bg-indigo-100 transition duration-150 ease-in-out group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-excluir inline-flex items-center px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition duration-150 ease-in-out group"
                                            data-nome="{{ $nomeFormatado }}">
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
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-lg mb-2">
                                Nenhum cliente cadastrado
                            </p>
                            <p class="text-gray-400 text-sm">
                                Comece cadastrando seu primeiro cliente!
                            </p>
                            <a href="{{ route('cliente.create') }}" 
                               class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Novo Cliente
                            </a>
                        </div>
                    @endforelse

                </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mt-4">Confirmar Exclusão</h3>
                
                <div class="mt-4 px-4 py-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600" id="mensagemModal">
                        Tem certeza que deseja excluir este cliente?
                    </p>
                    <p class="text-base font-bold text-indigo-600 mt-3 bg-white p-3 rounded-lg border border-gray-200 shadow-sm" id="nomeClienteModal">
                        Carregando...
                    </p>
                    <p class="text-xs text-red-500 mt-3">
                        Esta ação não poderá ser desfeita.
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
        /* Animações suaves para o modal */
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

        /* Efeito hover nos cards */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }

        /* Animação para mensagem de sucesso */
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

        .animate-pulse {
            animation: slideIn 0.5s ease-out;
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
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalConfirmacao');
        const formExclusao = document.getElementById('formExclusao');
        const nomeClienteModal = document.getElementById('nomeClienteModal');
        const cancelarBtn = document.getElementById('cancelarExclusao');
        
        // Previne múltiplos eventos
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
                
                // Pega o nome do cliente do atributo data-nome
                const nomeCliente = this.getAttribute('data-nome') || 'este cliente';
                
                // Atualiza o modal
                formExclusao.setAttribute('action', action);
                nomeClienteModal.textContent = nomeCliente;
                
                // Mostra o modal
                modal.classList.remove('hidden');
                modalAberto = true;
            });
        });

        // Validação de formulário (opcional)
        formExclusao.addEventListener('submit', function(e) {
            // Aqui você pode adicionar uma validação extra se necessário
            // Por exemplo, um log ou analytics
            console.log('Excluindo cliente:', nomeClienteModal.textContent);
        });
    });
    </script>

</x-app-layout>