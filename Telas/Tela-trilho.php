<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Ferrorama - Controle do Trilho</title>
    <!-- Bibliotecas Externas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos Centrais do Projeto -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR DA APLICAÇÃO -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid px-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a class="nav-link-custom" href="../index.php">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <span class="fw-bold fs-5 text-white">Sistema Ferrorama</span>
            </div>
            <div>
                <a href="tela-home.php" class="nav-link-custom" title="Configurações">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL (PAINEL DASHBOARD) -->
    <div class="container-fluid px-4 py-4 flex-grow-1">
        <div class="row g-4">

            <!-- CARD 1: CONTROLE DA LOCOMOTIVA -->
            <div class="col-lg-5">
                <div class="dashboard-card d-flex flex-column justify-content-between">
                    <div>
                        <div class="card-title-custom">Controle da Locomotiva</div>
                        
                        <!-- SLIDER DE VELOCIDADE -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-secondary small">Velocidade</span>
                                <span class="speed-value" id="label-velocidade">50%</span>
                            </div>
                            <input type="range" class="range-slider-custom" id="slider-velocidade" min="0" max="100" value="50">
                        </div>

                        <!-- BOTOES DE SENTIDO -->
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-2">Sentido</span>
                            <div class="row g-3">
                                <div class="col-6">
                                    <button class="btn-frente-style" id="btn-frente" onclick="alterarSentido('frente')">
                                        <i class="fa-solid fa-right-long"></i> Frente
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn-re-style" id="btn-re" onclick="alterarSentido('re')">
                                        <i class="fa-solid fa-right-long"></i> Ré
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BOTAO DE EMERGENCIA -->
                    <div>
                        <button class="btn-emergencia-custom" id="btn-emergencia" onclick="toggleEmergencia()">
                            <i class="fa-regular fa-circle-dot fs-5"></i> PARADA DE EMERGÊNCIA
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 2: MAPA DA PISTA -->
            <div class="col-lg-7">
                <div class="dashboard-card">
                    <div class="card-title-custom">Mapa da Pista</div>
                    
                    <div class="row align-items-center">
                        <!-- VETOR SVG DO TRILHO -->
                        <div class="col-md-8">
                            <svg viewBox="0 0 380 180" class="w-100 h-auto">
                                <!-- Circuito Oval Base -->
                                <path id="trilho-principal" d="M 90 35 L 290 35 A 55 55 0 0 1 290 145 L 90 145 A 55 55 0 0 1 90 35 Z" 
                                      fill="none" stroke="#1e3a5f" stroke-width="12" stroke-linecap="round" />
                                <path d="M 90 35 L 290 35 A 55 55 0 0 1 290 145 L 90 145 A 55 55 0 0 1 90 35 Z" 
                                      fill="none" stroke="#94a3b8" stroke-width="2" stroke-dasharray="5 4" />

                                <!-- Diagonal do Desvio -->
                                <path d="M 145 145 L 290 35" fill="none" stroke="#1e3a5f" stroke-width="8" />
                                <path d="M 145 145 L 290 35" fill="none" stroke="#64748b" stroke-width="2" stroke-dasharray="4 3" />

                                <!-- Elementos Fixos de Sinalização na Pista -->
                                <circle cx="145" cy="145" r="6" fill="#10b981" />
                                <circle cx="290" cy="35" r="6" fill="#64748b" />
                                <circle cx="305" cy="90" r="6" fill="#3b82f6" />

                                <!-- Locomotiva Vermelha Animada -->
                                <g id="locomotiva-marker">
                                    <rect x="-14" y="-7" width="28" height="14" rx="3" fill="#ef4444" stroke="#ffffff" stroke-width="1.5" />
                                    <circle cx="6" cy="0" r="3" fill="#ffffff" />
                                </g>
                            </svg>
                        </div>

                        <!-- LEGENDA INTEGRADA AO CARD -->
                        <div class="col-md-4 ps-md-3 mt-3 mt-md-0">
                            <div class="legend-box">
                                <div class="legend-row">
                                    <span class="icon-locomotiva"></span> Locomotiva
                                </div>
                                <div class="legend-row">
                                    <span class="dot-green-icon"></span> Desvio aberto
                                </div>
                                <div class="legend-row">
                                    <span class="dot-grey-icon"></span> Desvio fechado
                                </div>
                                <div class="legend-row">
                                    <span class="dot-blue-icon"></span> Sensor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 3: POSIÇÃO DA LOCOMOTIVA -->
            <div class="col-lg-5">
                <div class="dashboard-card">
                    <div class="card-title-custom">Posição da Locomotiva</div>
                    <div class="posicao-box">
                        <i class="fa-solid fa-train-subway train-icon-large"></i>
                        <div>
                            <div class="fw-bold fs-6 text-white" id="txt-posicao">Vagão 1 - Posição: 32% da pista</div>
                            <small class="text-secondary" id="txt-status-movimento">Em movimento para frente</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4: STATUS DO SISTEMA -->
            <div class="col-lg-7">
                <div class="dashboard-card">
                    <div class="card-title-custom">Status do Sistema</div>
                    <div class="status-grid">
                        <div class="status-item">
                            <span class="dot-green-icon" id="dot-conexao"></span>
                            <span id="txt-conexao">Conectado</span>
                        </div>
                        <div class="status-item">
                            <span class="dot-green-icon" id="dot-wifi"></span>
                            <span id="txt-wifi">Rede Wi-Fi</span>
                        </div>
                        <div class="status-item">
                            <span class="dot-green-icon" id="dot-tensao"></span>
                            <span id="txt-tensao">Tensão (12V)</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPTS DE INTERAÇÃO -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // VARIÁVEIS DE ESTADO
        let velocidade = 50;
        let sentido = 1; // 1 = Frente, -1 = Ré
        let posicaoPercentual = 32; // Início em 32% conforme a imagem
        let emEmergencia = false;

        // ELEMENTOS DOM
        const sliderVelocidade = document.getElementById('slider-velocidade');
        const labelVelocidade = document.getElementById('label-velocidade');
        const btnFrente = document.getElementById('btn-frente');
        const btnRe = document.getElementById('btn-re');
        const btnEmergencia = document.getElementById('btn-emergencia');
        const txtPosicao = document.getElementById('txt-posicao');
        const txtStatusMovimento = document.getElementById('txt-status-movimento');
        const locomotivaMarker = document.getElementById('locomotiva-marker');
        const trilhoPrincipal = document.getElementById('trilho-principal');

        const comprimentoTrilho = trilhoPrincipal.getTotalLength();

        // CONTROLE DO SLIDER
        sliderVelocidade.addEventListener('input', (e) => {
            if (emEmergencia) return;
            velocidade = parseInt(e.target.value);
            labelVelocidade.textContent = `${velocidade}%`;
            atualizarTextoStatus();
        });

        // TROCA DE SENTIDO (FRENTE / RÉ)
        function alterarSentido(novoSentido) {
            if (emEmergencia) return;

            if (novoSentido === 'frente') {
                sentido = 1;
                btnFrente.className = 'btn-frente-style';
                btnRe.className = 'btn-re-style';
            } else {
                sentido = -1;
                btnFrente.className = 'btn-frente-style desativado';
                btnRe.className = 'btn-re-style ativado';
            }
            atualizarTextoStatus();
        }

        // PARADA DE EMERGÊNCIA
        function toggleEmergencia() {
            emEmergencia = !emEmergencia;

            if (emEmergencia) {
                btnEmergencia.classList.add('ativo');
                labelVelocidade.textContent = '0%';
                txtStatusMovimento.textContent = 'PARADA DE EMERGÊNCIA ATIVADA!';
                txtStatusMovimento.className = 'text-danger fw-bold';
                document.getElementById('dot-tensao').className = 'dot-grey-icon';
            } else {
                btnEmergencia.classList.remove('ativo');
                velocidade = parseInt(sliderVelocidade.value);
                labelVelocidade.textContent = `${velocidade}%`;
                document.getElementById('dot-tensao').className = 'dot-green-icon';
                atualizarTextoStatus();
            }
        }

        function atualizarTextoStatus() {
            if (velocidade === 0) {
                txtStatusMovimento.textContent = 'Locomotiva parada';
                txtStatusMovimento.className = 'text-secondary';
            } else {
                txtStatusMovimento.textContent = sentido === 1 ? 'Em movimento para frente' : 'Em movimento para ré';
                txtStatusMovimento.className = 'text-success fw-bold';
            }
        }

        // ANIMAÇÃO DO TREM EM TEMPO REAL NO SVG
        function animarLocomotiva() {
            if (!emEmergencia && velocidade > 0) {
                const delta = (velocidade / 100) * 0.12 * sentido;
                posicaoPercentual += delta;

                if (posicaoPercentual > 100) posicaoPercentual = 0;
                if (posicaoPercentual < 0) posicaoPercentual = 100;

                txtPosicao.textContent = `Vagão 1 - Posição: ${Math.round(posicaoPercentual)}% da pista`;
            }

            // Ponto no caminho SVG
            const distancia = (posicaoPercentual / 100) * comprimentoTrilho;
            const ponto = trilhoPrincipal.getPointAtLength(distancia);
            
            // Ângulo para rotação
            const pontoFrente = trilhoPrincipal.getPointAtLength((distancia + 1) % comprimentoTrilho);
            const angulo = Math.atan2(pontoFrente.y - ponto.y, pontoFrente.x - ponto.x) * (180 / Math.PI);

            locomotivaMarker.setAttribute('transform', `translate(${ponto.x}, ${ponto.y}) rotate(${angulo})`);

            requestAnimationFrame(animarLocomotiva);
        }

        document.addEventListener('DOMContentLoaded', () => {
            animarLocomotiva();
        });
    </script>
</body>
</html>