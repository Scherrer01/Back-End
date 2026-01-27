import random
import time

# =========================
# CONFIGURAÇÕES DO SISTEMA
# =========================
TEMPO_VERDE_PADRAO = 10
TEMPO_AMARELO_PADRAO = 3
TEMPO_VERDE_ESTENDIDO = 18
TEMPO_AMARELO_CHUVA = 5

FLUXO_ALTO_LIMITE = 20


# =========================
# SIMULAÇÃO DOS SENSORES
# =========================
def ler_fluxo_veiculos():
    """Simula leitura do fluxo de veículos"""
    return random.randint(0, 30)


def ler_sensor_chuva():
    """Simula intensidade da chuva"""
    return random.choice(["nenhuma", "fraca", "forte"])


def sensor_funcionando():
    """Simula falha de sensor"""
    return random.choice([True, True, True, False])


def servidor_disponivel():
    """Simula queda do servidor"""
    return random.choice([True, True, False])


# =========================
# SAÍDA PARA LEDs (SIMULAÇÃO)
# =========================
def led_verde(tempo):
    print(f"🟢 VERDE ligado por {tempo}s")
    time.sleep(1)


def led_amarelo(tempo):
    print(f"🟡 AMARELO ligado por {tempo}s")
    time.sleep(1)


def led_vermelho():
    print("🔴 VERMELHO ligado")
    time.sleep(1)


def modo_seguranca():
    print("⚠️ FALHA DETECTADA → Pisca AMARELO")
    for _ in range(3):
        print("🟡 PISCANDO...")
        time.sleep(0.5)


# =========================
# ALGORITMO PRINCIPAL
# =========================
def semaforo_inteligente():
    fluxo_historico = []  # vetor para armazenar fluxo de veículos

    while True:
        print("\n--- NOVO CICLO DO SEMÁFORO ---")

        if not sensor_funcionando():
            modo_seguranca()
            continue

        fluxo = ler_fluxo_veiculos()
        chuva = ler_sensor_chuva()

        fluxo_historico.append(fluxo)

        tempo_verde = TEMPO_VERDE_PADRAO
        tempo_amarelo = TEMPO_AMARELO_PADRAO

        if fluxo > FLUXO_ALTO_LIMITE:
            tempo_verde = TEMPO_VERDE_ESTENDIDO

        if chuva == "forte":
            tempo_amarelo = TEMPO_AMARELO_CHUVA

        if servidor_disponivel():
            print("📡 Servidor conectado — dados enviados")
        else:
            print("📴 Servidor indisponível — execução local")

        # Simulação do semáforo
        led_verde(tempo_verde)
        led_amarelo(tempo_amarelo)
        led_vermelho()

        print(f"📊 Fluxo atual: {fluxo} veículos | Chuva: {chuva}")
        print(f"📈 Histórico de fluxo: {fluxo_historico[-5:]}")

        time.sleep(1)


# =========================
# EXECUÇÃO
# =========================
semaforo_inteligente()
