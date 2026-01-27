import tkinter as tk
import random

# =========================
# CONFIGURAÇÕES
# =========================
TEMPO_VERDE_PADRAO = 3000
TEMPO_VERDE_ESTENDIDO = 6000
TEMPO_AMARELO_PADRAO = 1500
TEMPO_AMARELO_CHUVA = 3000
FLUXO_ALTO_LIMITE = 20


# =========================
# SIMULAÇÃO DOS SENSORES
# =========================
def ler_fluxo():
    return random.randint(0, 30)


def ler_chuva():
    return random.choice(["nenhuma", "fraca", "forte"])


def sensor_funcionando():
    return random.choice([True, True, True, False])


def servidor_disponivel():
    return random.choice([True, True, False])


# =========================
# INTERFACE GRÁFICA
# =========================
janela = tk.Tk()
janela.title("Semáforo Inteligente IoT")
janela.geometry("300x400")

canvas = tk.Canvas(janela, width=200, height=300, bg="black")
canvas.pack(pady=10)

vermelho = canvas.create_oval(50, 20, 150, 120, fill="gray")
amarelo = canvas.create_oval(50, 120, 150, 220, fill="gray")
verde = canvas.create_oval(50, 220, 150, 320, fill="gray")

status_label = tk.Label(janela, text="", font=("Arial", 10))
status_label.pack()


# =========================
# FUNÇÕES DE CONTROLE
# =========================
def apagar_luzes():
    canvas.itemconfig(vermelho, fill="gray")
    canvas.itemconfig(amarelo, fill="gray")
    canvas.itemconfig(verde, fill="gray")


def ligar_verde(tempo):
    apagar_luzes()
    canvas.itemconfig(verde, fill="green")
    janela.after(tempo, ciclo_amarelo)


def ligar_amarelo(tempo):
    apagar_luzes()
    canvas.itemconfig(amarelo, fill="yellow")
    janela.after(tempo, ciclo_vermelho)


def ligar_vermelho():
    apagar_luzes()
    canvas.itemconfig(vermelho, fill="red")
    janela.after(2000, iniciar_ciclo)


def modo_seguranca():
    apagar_luzes()
    canvas.itemconfig(amarelo, fill="yellow")
    janela.after(500, apagar_luzes)
    janela.after(1000, modo_seguranca)


# =========================
# CICLO INTELIGENTE
# =========================
def iniciar_ciclo():
    if not sensor_funcionando():
        status_label.config(text="⚠️ Falha no sensor → Modo segurança")
        modo_seguranca()
        return

    fluxo = ler_fluxo()
    chuva = ler_chuva()

    tempo_verde = TEMPO_VERDE_PADRAO
    tempo_amarelo = TEMPO_AMARELO_PADRAO

    if fluxo > FLUXO_ALTO_LIMITE:
        tempo_verde = TEMPO_VERDE_ESTENDIDO

    if chuva == "forte":
        tempo_amarelo = TEMPO_AMARELO_CHUVA

    if servidor_disponivel():
        servidor = "Servidor conectado"
    else:
        servidor = "Servidor OFF (execução local)"

    status_label.config(
        text=f"Fluxo: {fluxo} | Chuva: {chuva}\n{servidor}"
    )

    ligar_verde(tempo_verde)


def ciclo_amarelo():
    ligar_amarelo(TEMPO_AMARELO_CHUVA)


def ciclo_vermelho():
    ligar_vermelho()


# =========================
# INICIAR SISTEMA
# =========================
iniciar_ciclo()
janela.mainloop()
