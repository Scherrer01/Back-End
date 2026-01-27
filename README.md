# Back-End
Aulas do Senai de Back-End 3° termo

# 🚦 Semáforo Inteligente com IoT

## 📌 Visão Geral
Este projeto tem como objetivo o desenvolvimento de um **Semáforo Inteligente baseado em IoT**, capaz de ajustar dinamicamente os tempos dos sinais de trânsito de acordo com o fluxo de veículos, condições climáticas e situações de falha, garantindo maior fluidez, segurança e confiabilidade no tráfego urbano.

O sistema foi desenvolvido em fases, contemplando levantamento de requisitos, modelagem da arquitetura IoT, segurança da informação e implementação de um **MVP funcional com interface visual**.

---

## 🧩 FASE 1 — Levantamento de Requisitos

### 🔹 Requisitos Funcionais
- **RF01** – Detectar o fluxo de veículos em cada via  
- **RF02** – Ajustar automaticamente o tempo do sinal verde  
- **RF03** – Detectar presença de pedestres  
- **RF04** – Controlar sinal sonoro para pedestres  
- **RF05** – Identificar condições climáticas adversas  
- **RF06** – Priorizar veículos de emergência  
- **RF07** – Entrar em modo seguro em caso de falha  
- **RF08** – Enviar dados em tempo real para a central  
- **RF09** – Permitir configuração manual por operador autorizado  

---

### 🔹 Requisitos Não Funcionais
- **RNF01** – Tempo de resposta inferior a 2 segundos  
- **RNF02** – Disponibilidade mínima de 99%  
- **RNF03** – Sistema escalável para múltiplos cruzamentos  
- **RNF04** – Comunicação de dados criptografada  
- **RNF05** – Interface da central deve ser intuitiva  
- **RNF06** – Sistema deve operar sob temperaturas de -10°C a 50°C  

---

### 🔹 Histórias de Usuário
- **HU01**  
  Como motorista, quero que o semáforo ajuste o tempo de verde conforme o trânsito, para reduzir congestionamentos.

- **HU02**  
  Como pedestre, quero tempo suficiente para atravessar com segurança, mesmo em dias de chuva.

- **HU03**  
  Como operador da central, quero ser notificado quando um sensor falhar, para agir rapidamente.

---

## 🌐 FASE 2 — Modelagem do Sistema e Arquitetura IoT

### 🔹 Arquitetura de Rede IoT do Cruzamento

#### Equipamentos de Rede
1. **Roteador**  
   Interliga redes diferentes e encaminha pacotes entre elas.

2. **Switch**  
   Conecta múltiplos dispositivos dentro da mesma rede local (LAN).

3. **Access Point**  
   Fornece conectividade Wi-Fi aos dispositivos IoT.

4. **Firewall**  
   Controla e filtra o tráfego de dados entre redes.

5. **Servidor Local**  
   Processa, armazena e gerencia os dados da rede IoT.

---

## 🛡️ FASE 3 — Sistema Operacional e Segurança

### 🔹 Comparação de Sistemas Operacionais

| Item | Windows Server | Ubuntu Server |
|----|---------------|---------------|
| Custo | Alto | Baixo |
| Segurança | Médio/Alto | Alto |
| Suporte a IoT | Médio | Alto |

### 🔹 Justificativa
O **Ubuntu Server** foi escolhido por apresentar menor custo, maior segurança e melhor suporte para ambientes IoT e edge computing.

---

### 🔹 Configurações em Laboratório / VM

**Criação de usuários**
```bash
sudo adduser aluno
whoami
