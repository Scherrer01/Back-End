import tkinter as tk
import random

# =========================
# CONFIGURAÇÕES (ms)
# =========================
TEMPO_VERDE = 4000
TEMPO_AMARELO = 3000
TEMPO_VERMELHO = 4000
TEMPO_VERDE_ESTENDIDO = 8000

# =========================
# JANELA
# =========================
janela = tk.Tk()
janela.title("Semáforo Inteligente - IoT")
janela.geometry("720x420")
janela.config(bg="gray20")

# =========================
# CANVAS
# =========================
canvas = tk.Canvas(janela, width=420, height=380, bg="black")
canvas.pack(side="left", padx=10)

# =========================
# SEMÁFORO
# =========================
vermelho = canvas.create_oval(160, 60, 260, 160, fill="gray")
amarelo = canvas.create_oval(160, 170, 260, 270, fill="gray")
verde = canvas.create_oval(160, 280, 260, 380, fill="gray")

# =========================
# STATUS + TIMER
# =========================
status_texto = canvas.create_text(
    210, 25,
    text="Sistema iniciado",
    fill="white",
    font=("Arial", 12, "bold"),
    justify="center"
)

timer_texto = canvas.create_text(
    210, 50,
    text="⏱️ Tempo: --",
    fill="cyan",
    font=("Arial", 11, "bold")
)

# =========================
# HISTÓRICO
# =========================
log_texto = tk.Text(
    janela,
    width=35,
    height=20,
    bg="black",
    fg="white",
    font=("Courier", 9)
)
log_texto.pack(side="right", padx=10)
log_texto.insert("end", "HISTÓRICO DO SISTEMA\n--------------------\n")
log_texto.config(state="disabled")

# =========================
# VARIÁVEL GLOBAL DO TIMER
# =========================
tempo_restante = 0

# =========================
# FUNÇÕES AUXILIARES
# =========================
def apagar_luzes():
    canvas.itemconfig(vermelho, fill="gray")
    canvas.itemconfig(amarelo, fill="gray")
    canvas.itemconfig(verde, fill="gray")

def registrar_evento(cor, motivo):
    log_texto.config(state="normal")
    log_texto.insert("end", f"{cor} → {motivo}\n")
    log_texto.see("end")
    log_texto.config(state="disabled")

def atualizar_status(cor, motivo, tipo):
    icones = {
        "fluxo": "🚗🚗🚗",
        "chuva": "🌧️",
        "seguranca": "⚠️",
        "normal": "✅"
    }

    cores_texto = {
        "VERDE": "green",
        "AMARELO": "yellow",
        "VERMELHO": "red",
        "SEGURANÇA": "orange"
    }

    texto = f"{icones[tipo]} {cor}\nMotivo: {motivo}"
    canvas.itemconfig(
        status_texto,
        text=texto,
        fill=cores_texto.get(cor, "white")
    )

    registrar_evento(cor, motivo)

# =========================
# TIMER REGRESSIVO
# =========================
def iniciar_timer(tempo_ms):
    global tempo_restante
    tempo_restante = tempo_ms // 1000
    atualizar_timer()

def atualizar_timer():
    global tempo_restante
    canvas.itemconfig(
        timer_texto,
        text=f"⏱️ Tempo: {tempo_restante}s"
    )

    if tempo_restante > 0:
        tempo_restante -= 1
        janela.after(1000, atualizar_timer)

# =========================
# SENSORES (SIMULAÇÃO)
# =========================
def sensor_fluxo():
    return random.randint(0, 100)

def sensor_chuva():
    return random.choice([True, False])

# =========================
# LÓGICA DO SEMÁFORO
# =========================
def decidir_verde():
    fluxo = sensor_fluxo()
    chuva = sensor_chuva()

    if fluxo > 30:
        verde_fluxo_alto()
    elif chuva:
        verde_chuva()
    else:
        verde_normal()

def verde_fluxo_alto():
    apagar_luzes()
    canvas.itemconfig(verde, fill="green")

    atualizar_status(
        "VERDE",
        "Fluxo alto de veículos detectado",
        "fluxo"
    )

    iniciar_timer(TEMPO_VERDE_ESTENDIDO)
    janela.after(TEMPO_VERDE_ESTENDIDO, semaforo_amarelo)

def verde_chuva():
    apagar_luzes()
    canvas.itemconfig(verde, fill="green")

    atualizar_status(
        "VERDE",
        "Chuva detectada – tráfego mais lento",
        "chuva"
    )

    iniciar_timer(TEMPO_VERDE_ESTENDIDO)
    janela.after(TEMPO_VERDE_ESTENDIDO, semaforo_amarelo)

def verde_normal():
    apagar_luzes()
    canvas.itemconfig(verde, fill="green")

    atualizar_status(
        "VERDE",
        "Fluxo normal de veículos",
        "normal"
    )

    iniciar_timer(TEMPO_VERDE)
    janela.after(TEMPO_VERDE, semaforo_amarelo)

def semaforo_amarelo():
    apagar_luzes()
    canvas.itemconfig(amarelo, fill="yellow")

    atualizar_status(
        "AMARELO",
        "Transição de sinal",
        "normal"
    )

    iniciar_timer(TEMPO_AMARELO)
    janela.after(TEMPO_AMARELO, semaforo_vermelho)

def semaforo_vermelho():
    apagar_luzes()
    canvas.itemconfig(vermelho, fill="red")

    atualizar_status(
        "VERMELHO",
        "Parada obrigatória",
        "normal"
    )

    iniciar_timer(TEMPO_VERMELHO)
    janela.after(TEMPO_VERMELHO, decidir_verde)

# =========================
# INICIAR SISTEMA
# =========================
decidir_verde()
janela.mainloop()
