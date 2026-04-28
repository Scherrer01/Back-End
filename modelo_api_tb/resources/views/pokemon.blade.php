<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Pokédex Master - Com Tipos de Ataques</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #1a0a0a 0%, #0f0a1a 50%, #1a0a0a 100%);
            min-height: 100vh;
        }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1e1a2b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 10px; }
        
        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .tab-btn.active {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 10px 25px -5px rgba(220,38,38,0.4);
        }
        .tab-btn.active i {
            color: white;
        }
        .tab-btn:not(.active):hover {
            background: rgba(220,38,38,0.15);
            border-color: rgba(220,38,38,0.5);
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }
        .tab-content.active-content {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Cores dos tipos de Pokémon */
        .type-normal { background: linear-gradient(135deg, #A8A878, #8A8A5C); }
        .type-fire { background: linear-gradient(135deg, #F08030, #C85C0C); }
        .type-water { background: linear-gradient(135deg, #6890F0, #3860C0); }
        .type-electric { background: linear-gradient(135deg, #F8D030, #D0A810); color: #1e293b; }
        .type-grass { background: linear-gradient(135deg, #78C850, #4A8C30); }
        .type-ice { background: linear-gradient(135deg, #98D8D8, #68B8B8); color: #1e293b; }
        .type-fighting { background: linear-gradient(135deg, #C03028, #902018); }
        .type-poison { background: linear-gradient(135deg, #A040A0, #702870); }
        .type-ground { background: linear-gradient(135deg, #E0C068, #B89840); color: #1e293b; }
        .type-flying { background: linear-gradient(135deg, #A890F0, #7860C0); }
        .type-psychic { background: linear-gradient(135deg, #F85888, #C02858); }
        .type-bug { background: linear-gradient(135deg, #A8B820, #788C10); }
        .type-rock { background: linear-gradient(135deg, #B8A038, #887020); }
        .type-ghost { background: linear-gradient(135deg, #705898, #483878); }
        .type-dragon { background: linear-gradient(135deg, #7038F8, #4820B0); }
        .type-dark { background: linear-gradient(135deg, #705848, #4A3828); }
        .type-steel { background: linear-gradient(135deg, #B8B8D0, #9090A8); color: #1e293b; }
        .type-fairy { background: linear-gradient(135deg, #EE99AC, #D87090); }
        
        /* Cores dos tipos de ataques (mesmas cores) */
        .move-type-normal { background: #A8A878; }
        .move-type-fire { background: #F08030; }
        .move-type-water { background: #6890F0; }
        .move-type-electric { background: #F8D030; color: #1e293b; }
        .move-type-grass { background: #78C850; }
        .move-type-ice { background: #98D8D8; color: #1e293b; }
        .move-type-fighting { background: #C03028; }
        .move-type-poison { background: #A040A0; }
        .move-type-ground { background: #E0C068; color: #1e293b; }
        .move-type-flying { background: #A890F0; }
        .move-type-psychic { background: #F85888; }
        .move-type-bug { background: #A8B820; }
        .move-type-rock { background: #B8A038; }
        .move-type-ghost { background: #705898; }
        .move-type-dragon { background: #7038F8; }
        .move-type-dark { background: #705848; }
        .move-type-steel { background: #B8B8D0; color: #1e293b; }
        .move-type-fairy { background: #EE99AC; }
        
        .stat-bar-bg {
            background: rgba(0,0,0,0.4);
            border-radius: 20px;
            overflow: hidden;
        }
        .stat-fill {
            background: linear-gradient(90deg, #ef4444, #dc2626, #b91c1c);
            border-radius: 20px;
            height: 10px;
            transition: width 0.6s ease-out;
        }
        
        .evo-card {
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .evo-card:hover {
            transform: translateY(-5px);
            background: rgba(220,38,38,0.15);
            border-color: #ef4444 !important;
        }
        
        .loader {
            border: 4px solid rgba(220,38,38,0.2);
            border-radius: 50%;
            border-top: 4px solid #ef4444;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .glow-text {
            text-shadow: 0 2px 15px rgba(220,38,38,0.4);
        }
        
        input:focus { outline: none; box-shadow: 0 0 0 3px rgba(220,38,38,0.3); }
        button:active { transform: scale(0.97); }
        
        .move-card {
            transition: all 0.2s ease;
        }
        .move-card:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body class="p-4 md:p-6">

    <div class="max-w-6xl mx-auto">
        <!-- Header Principal -->
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4" data-aos="fade-down">
            <div class="flex items-center gap-3 bg-white/5 backdrop-blur rounded-2xl px-6 py-3 border border-white/10">
                <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-full p-3 shadow-xl">
                    <i class="fas fa-pokeball text-3xl text-white drop-shadow-md"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-black">
                        <span class="text-white">Pokédex</span> <span class="text-red-500 glow-text">Master</span>
                    </h1>
                    <p class="text-gray-400 text-sm">Com tipos de ataques!</p>
                </div>
            </div>
            
            <div class="flex gap-3 w-full lg:w-auto">
                <div class="relative flex-grow lg:w-80">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Nome ou ID... (ex: Charizard, 25)" 
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/10 backdrop-blur border border-white/20 text-white placeholder-gray-400 focus:bg-white/20 transition">
                </div>
                <button id="searchBtn" class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-400 hover:to-red-600 px-6 rounded-xl font-bold text-white transition shadow-lg">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
            </div>
        </div>

        <!-- Área do Pokémon Atual -->
        <div id="pokemonHeaderArea" class="mb-6" data-aos="fade-up"></div>

        <!-- Sistema de Abas -->
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl border border-white/20 overflow-hidden mb-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-col sm:flex-row border-b border-white/10">
                <button class="tab-btn active flex-1 py-4 px-6 text-center font-bold text-lg transition-all flex items-center justify-center gap-3 bg-white/5" data-tab="status">
                    <i class="fas fa-chart-line text-xl"></i>
                    <span>📊 STATUS</span>
                </button>
                <button class="tab-btn flex-1 py-4 px-6 text-center font-bold text-lg transition-all flex items-center justify-center gap-3 bg-white/5" data-tab="moves">
                    <i class="fas fa-fist-raised text-xl"></i>
                    <span>⚔️ ATAQUES</span>
                </button>
                <button class="tab-btn flex-1 py-4 px-6 text-center font-bold text-lg transition-all flex items-center justify-center gap-3 bg-white/5" data-tab="evolutions">
                    <i class="fas fa-chart-simple text-xl"></i>
                    <span>🔄 EVOLUÇÕES</span>
                </button>
            </div>
            
            <div class="p-6">
                <div id="tabStatus" class="tab-content active-content">
                    <div id="statusContent" class="min-h-[300px]">
                        <div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando status...</p></div>
                    </div>
                </div>
                <div id="tabMoves" class="tab-content">
                    <div id="movesContent" class="min-h-[300px]">
                        <div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando ataques...</p></div>
                    </div>
                </div>
                <div id="tabEvolutions" class="tab-content">
                    <div id="evolutionsContent" class="min-h-[300px]">
                        <div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando evoluções...</p></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de Navegação -->
        <div class="flex justify-between gap-4" data-aos="fade-up" data-aos-delay="150">
            <button id="prevBtn" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg">
                <i class="fas fa-chevron-left"></i> Anterior
            </button>
            <button id="randomBtn" class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-400 hover:to-red-600 text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2 shadow-xl">
                <i class="fas fa-dice-d6"></i> Aleatório
            </button>
            <button id="nextBtn" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg">
                Próximo <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        
        let currentPokemonData = null;
        let currentSpeciesData = null;
        let currentEvolutionChain = [];
        let currentMovesList = []; // Agora vai conter {name, type, typeName}
        let currentStats = [];
        let currentAbilities = [];
        
        function setupTabs() {
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active-content');
                    });
                    if (tabId === 'status') document.getElementById('tabStatus').classList.add('active-content');
                    if (tabId === 'moves') document.getElementById('tabMoves').classList.add('active-content');
                    if (tabId === 'evolutions') document.getElementById('tabEvolutions').classList.add('active-content');
                });
            });
        }
        
        function getStatNamePt(statEn) {
            const map = {
                'hp': 'HP (Vida)',
                'attack': 'Ataque',
                'defense': 'Defesa',
                'special-attack': 'Ataque Especial',
                'special-defense': 'Defesa Especial',
                'speed': 'Velocidade'
            };
            return map[statEn] || statEn;
        }
        
        // Função para buscar o tipo de cada movimento
        async function fetchMoveType(moveUrl) {
            try {
                const response = await fetch(moveUrl);
                const moveData = await response.json();
                const typeName = moveData.type.name;
                return typeName;
            } catch (error) {
                console.error('Erro ao buscar tipo do movimento:', error);
                return 'normal';
            }
        }
        
        async function loadPokemon(identifier) {
            document.getElementById('statusContent').innerHTML = `<div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando status...</p></div>`;
            document.getElementById('movesContent').innerHTML = `<div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando ataques e tipos...</p></div>`;
            document.getElementById('evolutionsContent').innerHTML = `<div class="flex justify-center py-10"><div class="loader"></div><p class="text-white ml-4">Carregando evoluções...</p></div>`;
            
            try {
                let normalizedId = identifier.toString().toLowerCase().trim();
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${normalizedId}`);
                if (!response.ok) throw new Error('Pokémon não encontrado');
                const pokemon = await response.json();
                currentPokemonData = pokemon;
                
                const speciesRes = await fetch(pokemon.species.url);
                currentSpeciesData = await speciesRes.json();
                
                let descText = "Nenhuma descrição disponível.";
                const ptEntry = currentSpeciesData.flavor_text_entries.find(entry => entry.language.name === 'pt');
                const enEntry = currentSpeciesData.flavor_text_entries.find(entry => entry.language.name === 'en');
                if (ptEntry) descText = ptEntry.flavor_text.replace(/\f|\n/g, ' ');
                else if (enEntry) descText = enEntry.flavor_text.replace(/\f|\n/g, ' ');
                
                currentEvolutionChain = [];
                if (currentSpeciesData.evolution_chain) {
                    const evoRes = await fetch(currentSpeciesData.evolution_chain.url);
                    const evoData = await evoRes.json();
                    currentEvolutionChain = await extractEvolutionChain(evoData.chain);
                }
                
                // Buscar movimentos com seus tipos
                const movesWithTypes = [];
                const movesToFetch = pokemon.moves.slice(0, 24); // Limitar a 24 para performance
                
                for (const move of movesToFetch) {
                    const moveType = await fetchMoveType(move.move.url);
                    let moveName = move.move.name.replace(/-/g, ' ');
                    moveName = moveName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                    movesWithTypes.push({
                        name: moveName,
                        type: moveType,
                        typeName: capitalizeFirst(moveType)
                    });
                }
                currentMovesList = movesWithTypes;
                
                currentStats = pokemon.stats.map(stat => ({
                    name: getStatNamePt(stat.stat.name),
                    value: stat.base_stat
                }));
                
                currentAbilities = pokemon.abilities.map(ab => ({
                    name: ab.ability.name.replace(/-/g, ' ').toUpperCase(),
                    isHidden: ab.is_hidden
                }));
                
                updatePokemonHeader(pokemon, descText);
                renderStatusTab();
                renderMovesTab();
                renderEvolutionsTab();
                
            } catch (error) {
                const errorHtml = `
                    <div class="text-center py-10">
                        <i class="fas fa-exclamation-triangle text-6xl text-red-400 mb-4"></i>
                        <h3 class="text-2xl font-bold text-white mb-2">Pokémon não encontrado!</h3>
                        <p class="text-gray-300">"${identifier}" não está na Pokédex.</p>
                        <button onclick="loadPokemon('pikachu')" class="mt-4 bg-gradient-to-r from-red-500 to-red-700 px-6 py-2 rounded-lg font-bold text-white">Carregar Pikachu</button>
                    </div>
                `;
                document.getElementById('statusContent').innerHTML = errorHtml;
                document.getElementById('movesContent').innerHTML = errorHtml;
                document.getElementById('evolutionsContent').innerHTML = errorHtml;
                document.getElementById('pokemonHeaderArea').innerHTML = '';
            }
        }
        
        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
        
        async function extractEvolutionChain(chain) {
            let evolutions = [];
            let current = chain;
            while(current) {
                const speciesName = current.species.name;
                const id = await getPokemonIdFromUrl(current.species.url);
                evolutions.push({ 
                    name: speciesName.charAt(0).toUpperCase() + speciesName.slice(1), 
                    id: id,
                    nameLower: speciesName
                });
                if(current.evolves_to && current.evolves_to.length > 0) {
                    current = current.evolves_to[0];
                } else break;
            }
            return evolutions;
        }
        
        async function getPokemonIdFromUrl(url) {
            const parts = url.split('/');
            return parseInt(parts[parts.length - 2]);
        }
        
        function updatePokemonHeader(pokemon, description) {
            const name = pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1);
            const id = String(pokemon.id).padStart(3, '0');
            const imageUrl = pokemon.sprites.other?.['official-artwork']?.front_default || pokemon.sprites.front_default;
            const types = pokemon.types.map(t => t.type.name);
            const height = (pokemon.height / 10).toFixed(1);
            const weight = (pokemon.weight / 10).toFixed(1);
            
            const headerHtml = `
                <div class="bg-gradient-to-br from-gray-800/60 to-gray-900/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20">
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <div class="bg-white/5 rounded-2xl p-4">
                            <img src="${imageUrl}" alt="${name}" class="w-48 h-48 object-contain drop-shadow-2xl">
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="inline-block bg-black/50 px-3 py-1 rounded-full mb-2">
                                <span class="text-red-400 font-mono font-bold">Nº ${id}</span>
                            </div>
                            <h2 class="text-4xl font-black text-white mb-2">${name}</h2>
                            <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-3">
                                ${types.map(t => `<span class="type-${t} px-4 py-1 rounded-full text-sm font-bold shadow-md capitalize">${t}</span>`).join('')}
                            </div>
                            <p class="text-gray-300 text-sm max-w-lg mx-auto md:mx-0 italic">${description.substring(0, 120)}${description.length > 120 ? '...' : ''}</p>
                            <div class="flex justify-center md:justify-start gap-4 mt-3 text-sm">
    <span class="text-white"><i class="fas fa-ruler text-red-400"></i> ${height}m</span>
    <span class="text-white"><i class="fas fa-weight-hanging text-red-400"></i> ${weight}kg</span>
</div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('pokemonHeaderArea').innerHTML = headerHtml;
        }
        
        function renderStatusTab() {
            if (!currentPokemonData) return;
            const habitat = currentSpeciesData?.habitat?.name || 'desconhecido';
            const captureRate = currentSpeciesData?.capture_rate || '?';
            
            const statusHtml = `
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-line text-red-400"></i> Estatísticas Base
                        </h3>
                        <div class="space-y-3">
                            ${currentStats.map(stat => `
                                <div>
                                    <div class="flex justify-between text-gray-200 mb-1">
                                        <span class="font-semibold">${stat.name}</span>
                                        <span class="text-red-400 font-bold">${stat.value}</span>
                                    </div>
                                    <div class="stat-bar-bg">
                                        <div class="stat-fill" style="width: ${Math.min(100, stat.value / 2.55)}%"></div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-brain text-red-400"></i> Habilidades
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            ${currentAbilities.map(ab => `
                                <div class="bg-red-500/20 border border-red-500/40 rounded-xl px-4 py-2">
                                    <span class="text-red-200 font-semibold">${ab.name}</span>
                                    ${ab.isHidden ? '<span class="ml-2 text-xs bg-black/50 px-2 py-0.5 rounded-full text-red-300">Oculta</span>' : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-red-400"></i> Informações Adicionais
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-black/30 rounded-xl p-3 text-center">
                                <i class="fas fa-tree text-red-400"></i>
                                <p class="text-gray-400 text-xs mt-1">Habitat</p>
                                <p class="text-white font-semibold capitalize">${habitat}</p>
                            </div>
                            <div class="bg-black/30 rounded-xl p-3 text-center">
                                <i class="fas fa-chart-line text-red-400"></i>
                                <p class="text-gray-400 text-xs mt-1">Taxa de Captura</p>
                                <p class="text-white font-semibold">${captureRate}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('statusContent').innerHTML = statusHtml;
        }
        
        function renderMovesTab() {
            if (!currentPokemonData) return;
            if (currentMovesList.length === 0) {
                document.getElementById('movesContent').innerHTML = `<div class="text-center py-10"><i class="fas fa-fist-raised text-5xl text-gray-500 mb-3"></i><p class="text-gray-400">Este Pokémon não possui ataques registrados.</p></div>`;
                return;
            }
            
            const movesHtml = `
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="fas fa-fist-raised text-red-400"></i> Lista de Ataques
                        </h3>
                        <span class="text-gray-400 text-sm">Total: ${currentMovesList.length} movimentos</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[500px] overflow-y-auto pr-2">
                        ${currentMovesList.map(move => `
                            <div class="move-card bg-gray-800/50 hover:bg-gray-700/70 transition rounded-lg p-3 flex items-center justify-between border border-gray-700">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-bolt text-red-400 text-sm"></i>
                                    <span class="text-gray-100 font-medium">${move.name}</span>
                                </div>
                                <span class="move-type-${move.type} px-3 py-1 rounded-full text-xs font-bold shadow-md capitalize">
                                    ${move.typeName}
                                </span>
                            </div>
                        `).join('')}
                    </div>
                   
                </div>
            `;
            document.getElementById('movesContent').innerHTML = movesHtml;
        }
        
        function renderEvolutionsTab() {
            if (!currentPokemonData) return;
            if (currentEvolutionChain.length === 0 || currentEvolutionChain.length === 1) {
                document.getElementById('evolutionsContent').innerHTML = `
                    <div class="text-center py-10">
                        <i class="fas fa-ban text-5xl text-gray-500 mb-3"></i>
                        <p class="text-gray-300 text-lg">Este Pokémon não possui evoluções.</p>
                        <p class="text-gray-500 text-sm mt-2">Forma básica sem cadeia evolutiva</p>
                    </div>
                `;
                return;
            }
            
            const evolutionsHtml = `
                <div>
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-simple text-red-400"></i> Cadeia Evolutiva
                    </h3>
                    <div class="flex flex-wrap justify-center items-center gap-6 md:gap-8">
                        ${currentEvolutionChain.map((evo, idx) => `
                            <div class="evo-card text-center bg-white/5 rounded-2xl p-4 border border-white/20 transition-all min-w-[130px]" onclick="loadPokemon('${evo.nameLower}')">
                                <div class="w-28 h-28 mx-auto bg-gradient-to-br from-gray-700/50 to-gray-800 rounded-full flex items-center justify-center p-2">
                                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${evo.id}.png" 
                                         alt="${evo.name}" class="w-24 h-24 object-contain drop-shadow-md hover:scale-110 transition">
                                </div>
                                <p class="text-white font-bold mt-3 text-lg">${evo.name}</p>
                                <span class="text-red-400 text-xs font-mono">#${String(evo.id).padStart(3, '0')}</span>
                                <div class="mt-2 text-red-500 text-xs"><i class="fas fa-mouse-pointer"></i> Clique para ver</div>
                            </div>
                            ${idx !== currentEvolutionChain.length-1 ? `<i class="fas fa-arrow-right text-4xl text-red-500 hidden md:block"></i>` : ''}
                        `).join('')}
                    </div>
                    <p class="text-center text-gray-400 text-sm mt-6"><i class="fas fa-info-circle"></i> Clique em qualquer evolução para carregar seus dados</p>
                </div>
            `;
            document.getElementById('evolutionsContent').innerHTML = evolutionsHtml;
        }
        
        function changePokemon(delta) {
            if (!currentPokemonData) return;
            let newId = currentPokemonData.id + delta;
            if (newId < 1) newId = 1;
            if (newId > 1025) newId = 1025;
            loadPokemon(newId);
        }
        
        function randomPokemon() {
            const randomId = Math.floor(Math.random() * 898) + 1;
            loadPokemon(randomId);
        }
        
        window.loadPokemon = loadPokemon;
        
        document.getElementById('prevBtn').addEventListener('click', () => changePokemon(-1));
        document.getElementById('nextBtn').addEventListener('click', () => changePokemon(1));
        document.getElementById('randomBtn').addEventListener('click', () => randomPokemon());
        document.getElementById('searchBtn').addEventListener('click', () => {
            const query = document.getElementById('searchInput').value.trim();
            if (query) loadPokemon(query);
        });
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') document.getElementById('searchBtn').click();
        });
        
        setupTabs();
        loadPokemon('pikachu');
    </script>
</body>
</html>