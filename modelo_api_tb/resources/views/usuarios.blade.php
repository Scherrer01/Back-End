<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>UserHub - Plataforma Corporativa de Gestão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        body {
            background: #f1f5f9;
        }
        
        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        }
        
        .stat-fill {
            background: #2563eb;
            border-radius: 4px;
            height: 6px;
        }
        
        .info-row:hover {
            background: #f8fafc;
        }
        
        button {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        button:active {
            transform: scale(0.97);
        }
        
        .badge {
            background: #eff6ff;
            color: #1e40af;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .status-active {
            background: #22c55e;
            box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px #22c55e20;
        }
        
        .avatar-bg {
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Top Navigation Bar -->
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">UserHub</h1>
                    <p class="text-sm text-gray-500">Plataforma corporativa de gestão</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-id-card"></i>
                    <span>ID: {{ $usuario['id'] }}</span>
                </div>
                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-circle text-gray-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Breadcrumb -->
        <div class="mb-6">
            <p class="text-sm text-gray-500">
                <i class="fas fa-home mr-1"></i> Dashboard / 
                <span class="text-gray-700 font-medium">Usuários</span> / 
                <span class="text-gray-900">{{ $usuario['firstName'] }} {{ $usuario['lastName'] }}</span>
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- COLUNA ESQUERDA - Perfil -->
            <div class="lg:col-span-1">
                <div class="card rounded-xl overflow-hidden sticky top-8">
                    <div class="h-24 bg-gray-800 relative">
                        <div class="absolute -bottom-12 left-6">
                            <div class="w-24 h-24 avatar-bg rounded-xl flex items-center justify-center border-4 border-white shadow-md">
                                <i class="fas fa-user text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-16 pb-6 px-6">
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-gray-900">{{ $usuario['firstName'] }} {{ $usuario['lastName'] }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ $usuario['email'] }}</p>
                        </div>
                        
                        <div class="flex gap-2 mb-6">
                            <span class="badge px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-{{ $usuario['gender'] == 'male' ? 'mars' : ($usuario['gender'] == 'female' ? 'venus' : 'genderless') }} mr-1"></i>
                                {{ $usuario['gender'] == 'male' ? 'Masculino' : ($usuario['gender'] == 'female' ? 'Feminino' : 'Não especificado') }}
                            </span>
                            <span class="badge px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-calendar mr-1"></i> {{ $usuario['age'] }} anos
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-500">Status da conta</span>
                                <span class="flex items-center gap-1 text-green-600 text-sm font-medium">
                                    <span class="status-active w-2 h-2 rounded-full inline-block"></span>
                                    Ativo
                                </span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-500">Membro desde</span>
                                <span class="text-gray-700">{{ date('M Y', strtotime('-' . rand(1, 24) . ' months')) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Último acesso</span>
                                <span class="text-gray-700">{{ date('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- COLUNA DIREITA -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Card de Contato -->
                <div class="card rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone-alt text-blue-600 text-sm"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Informações de Contato</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Telefone</p>
                                <p class="text-gray-900 font-medium">{{ $usuario['phone'] ?? 'Não informado' }}</p>
                            </div>
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Email</p>
                                <p class="text-gray-900 font-medium break-all">{{ $usuario['email'] }}</p>
                            </div>
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Data de Nascimento</p>
                                <p class="text-gray-900 font-medium">{{ $usuario['birthDate'] ?? 'Não informado' }}</p>
                            </div>
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Idade</p>
                                <p class="text-gray-900 font-medium">{{ $usuario['age'] }} anos</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card de Endereço -->
                <div class="card rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-emerald-600 text-sm"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Endereço</h3>
                    </div>
                    <div class="p-6">
                        @php $address = $usuario['address'] ?? []; @endphp
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Logradouro</p>
                                <p class="text-gray-900 font-medium">{{ $address['address'] ?? 'Não informado' }}</p>
                            </div>
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Cidade</p>
                                <p class="text-gray-900 font-medium">{{ $address['city'] ?? 'Não informado' }}</p>
                            </div>
                            <div class="info-row p-3 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">País</p>
                                <p class="text-gray-900 font-medium">{{ $address['country'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card de Métricas -->
                <div class="card rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-purple-600 text-sm"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Métricas de Atividade</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-900">{{ rand(85, 99) }}%</p>
                                <p class="text-xs text-gray-500 mt-1">Taxa de conclusão</p>
                                <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                    <div class="stat-fill" style="width: {{ rand(85, 99) }}%;"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-900">{{ rand(24, 365) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Dias ativo</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-900">{{ rand(3, 48) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Interações</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botão de Navegação - IGUAL AO POKEMON (apenas um botão que recarrega a página) -->
        <div class="flex justify-center mt-8 pt-4 border-t border-gray-200">
            <button onclick="window.location.reload()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Buscar Próximo Usuário
            </button>
        </div>
        
        <!-- Footer -->
        <footer class="mt-10 pt-6 border-t border-gray-200 text-center">
            <div class="flex justify-center gap-6 text-xs text-gray-400">
                <span><i class="fas fa-database mr-1"></i> Dados via DummyJSON API</span>
                <span><i class="fas fa-shield-alt mr-1"></i> Ambiente corporativo</span>
                <span><i class="fas fa-chart-simple mr-1"></i> UserHub v2.0</span>
            </div>
            <p class="text-xs text-gray-400 mt-3">© 2024 UserHub - Plataforma de Gestão de Usuários</p>
        </footer>
    </div>
</body>
</html>