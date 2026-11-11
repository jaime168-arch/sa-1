<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

include '../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);
$isAdmin     = ($_SESSION['usuario_tipo'] ?? '') === 'admin';

$totalTrens = 0;
$resTrens = $conn->query("SELECT COUNT(*) AS total FROM trens");
if ($resTrens) {
    $totalTrens = $resTrens->fetch_assoc()['total'];
}

$totalRotas = 0;
$resRotas = $conn->query("SELECT COUNT(*) AS total FROM rotas");
if ($resRotas) {
    $totalRotas = $resRotas->fetch_assoc()['total'];
}

$totalSensores = 0;
$resSensores = $conn->query("SELECT COUNT(*) AS total FROM sensores");
if ($resSensores) {
    $totalSensores = $resSensores->fetch_assoc()['total'];
}

$totalUsuarios = 0;
$resUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
if ($resUsuarios) {
    $totalUsuarios = $resUsuarios->fetch_assoc()['total'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Painel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        :root {
            --brand-color: #ff6600;
            --brand-hover: #e05500;
            --bg-page: #f8fafc;
            --beige-card: #f5efe6;
            --beige-dark: #e8dec9;
            --beige-text: #4a3f35;
        }
        body {
            background-color: var(--bg-page);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #334155;
        }
        .btn-brand {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: var(--brand-hover);
            color: #ffffff;
        }
        .logo-nav-central {
            max-height: 70px;
            width: auto;
            mix-blend-mode: multiply;
        }
        .card-clima-beige {
            background-color: var(--beige-card);
            border: 1px solid var(--beige-dark);
            color: var(--beige-text);
        }
        .badge-beige-tag {
            background-color: #e3d4ad;
            color: #5c4d3c;
            font-weight: 600;
        }

        /* Estilização da Telemetria e Circuito Animado */
        .telemetria-container {
            background-color: #111111;
            border-radius: 1.25rem;
            padding: 30px;
            color: #ffffff;
            border: 1px solid #222222;
        }

        .track-box {
            width: 200px;
            height: 320px;
        }

        .track-box svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .track-glow {
            fill: none;
            stroke: #ff7b00;
            stroke-width: 10;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0.35;
            filter: blur(4px);
        }

        .track-line {
            fill: none;
            stroke: #ff9900;
            stroke-width: 4.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .gps-dot {
            fill: #ffffff;
            stroke: #4ade80;
            stroke-width: 2.5;
            filter: drop-shadow(0 0 6px #4ade80);
        }

        .info-panel {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .info-block .label {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: #888888;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .info-block .value {
            font-size: 30px;
            font-weight: 700;
            color: #f3f4f6;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top py-3" style="background-color: #ff6600 !important;">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center me-4" href="home.php">
            <img src="../assets/img_2.png" alt="Logo Já.Ismaga" height="75" class="logo-nav-central align-top">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold fs-6">
                <li class="nav-item"><a class="nav-link text-dark fw-bold active" href="home.php">Início</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="usuarios.php">Usuários</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="trens.php">Trens</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="rotas.php">Rotas</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="sensores.php">Sensores</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="text-dark fs-6">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3 py-2 fw-semibold"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
            </div>
        </div>
    </div>
</nav>

<main class="container my-5">
    <div class="row mb-4">
        <div class="col-lg-7 mb-3 mb-lg-0">
            <div class="p-4 rounded-4 bg-white shadow-sm border border-light-subtle h-100 d-flex flex-column justify-content-center">
                <h2 class="fw-bold text-dark m-0">Bem-vindo(a) <?= htmlspecialchars($nomeUsuario); ?> ao Já Ismaga</h2>
                <p class="text-muted mt-2 mb-0">Sistema industrial de monitoramento ferroviário e telemetria em tempo real.</p>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 card-clima-beige">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge badge-beige-tag mb-2"><i class="bi bi-geo-alt-fill me-1"></i>Estação Ferroviária</span>
                            <h4 class="fw-bold mb-0 text-dark">Joinville, SC</h4>
                            <small class="text-muted" id="clima-data">Carregando dados...</small>
                        </div>
                        <div class="text-end">
                            <h2 class="display-6 fw-bold mb-0" style="color: #634d32;" id="clima-temp">--°C</h2>
                            <span id="clima-condicao" class="badge bg-white text-dark border border-secondary-subtle">--</span>
                        </div>
                    </div>
                    
                    <hr class="my-3" style="border-color: #d1c4b2;">

                    <div class="row text-center g-2 small">
                        <div class="col-4 border-end" style="border-color: #d1c4b2 !important;">
                            <span class="text-muted d-block"><i class="bi bi-wind me-1"></i>Vento</span>
                            <strong class="text-dark" id="clima-vento">-- km/h</strong>
                        </div>
                        <div class="col-4 border-end" style="border-color: #d1c4b2 !important;">
                            <span class="text-muted d-block"><i class="bi bi-compass me-1"></i>Direção</span>
                            <strong class="text-dark" id="clima-direcao">--</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted d-block"><i class="bi bi-cloud-sun me-1"></i>Status</span>
                            <strong class="text-dark" id="clima-status">OK</strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Telemetria com Mapa do Circuito Integrado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="telemetria-container shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                    <h5 class="fw-bold m-0 text-white d-flex align-items-center gap-2">
                        <i class="bi bi-broadcast text-warning"></i> Telemetria em Tempo Real — Circuito Ferrorama
                    </h5>
                    <span class="badge bg-success text-white px-3 py-2">
                        <i class="bi bi-wifi me-1"></i> GPS Conectado
                    </span>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-around align-items-center gap-4">
                    <!-- Mapa do Circuito SVG -->
                    <div class="track-box">
                        <svg viewBox="0 0 200 340">
                            <!-- Brilho externo da pista -->
                            <path id="track-path" class="track-glow" d="
                                M 135,280 
                                C 110,275 100,250 115,215 
                                C 130,180 120,165 100,175 
                                C 80,185 65,215 55,205 
                                C 45,195 65,155 85,135 
                                C 105,115 95,100 75,115 
                                C 55,130 40,170 30,160 
                                C 20,150 35,90 55,65 
                                C 75,40 125,25 145,45 
                                C 165,65 165,255 155,280 
                                C 145,305 60,315 40,295 
                                C 20,275 20,195 30,185
                                C 40,175 60,235 80,255
                                C 100,275 160,285 135,280 Z" />

                            <!-- Linha principal da pista -->
                            <path class="track-line" d="
                                M 135,280 
                                C 110,275 100,250 115,215 
                                C 130,180 120,165 100,175 
                                C 80,185 65,215 55,205 
                                C 45,195 65,155 85,135 
                                C 105,115 95,100 75,115 
                                C 55,130 40,170 30,160 
                                C 20,150 35,90 55,65 
                                C 75,40 125,25 145,45 
                                C 165,65 165,255 155,280 
                                C 145,305 60,315 40,295 
                                C 20,275 20,195 30,185
                                C 40,175 60,235 80,255
                                C 100,275 160,285 135,280 Z" />

                            <!-- Marcador animado por JavaScript -->
                            <circle id="marker" class="gps-dot" r="5" cx="0" cy="0" />
                        </svg>
                    </div>

                    <!-- Painel de Informações Operacionais -->
                    <div class="info-panel">
                        <div class="info-block">
                            <div class="label">Extensão do Trajeto</div>
                            <div class="value">7,960 km</div>
                        </div>

                        <div class="info-block">
                            <div class="label">Sensores GPS Ativos</div>
                            <div class="value">7</div>
                        </div>

                        <div class="info-block">
                            <div class="label">Velocidade Média</div>
                            <div class="value text-warning">48.5 km/h</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Métricas -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-3 fs-3"><i class="bi bi-train-front"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Trens Ativos</h6>
                        <h3 class="fw-bold m-0"><?= $totalTrens; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-primary-subtle text-primary rounded-3 fs-3"><i class="bi bi-signpost-split"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Rotas Cadastradas</h6>
                        <h3 class="fw-bold m-0"><?= $totalRotas; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-success-subtle text-success rounded-3 fs-3"><i class="bi bi-cpu"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Sensores IoT</h6>
                        <h3 class="fw-bold m-0"><?= $totalSensores; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-info-subtle text-info-emphasis rounded-3 fs-3"><i class="bi bi-people"></i></div>
                    <div>
                        <h6 class="text-muted mb-1">Usuários</h6>
                        <h3 class="fw-bold m-0"><?= $totalUsuarios; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
    <div class="container">&copy; <?= date('Y'); ?> <strong>Já Ismaga</strong>. Todos os direitos reservados.</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animação JavaScript nativa do GPS sobre o caminho do circuito
    const path = document.getElementById('track-path');
    const marker = document.getElementById('marker');
    const pathLength = path.getTotalLength();
    const duration = 8000; // 8 segundos por volta
    let startTime = null;

    function animateTrack(timestamp) {
        if (!startTime) startTime = timestamp;
        const elapsed = timestamp - startTime;
        const progress = (elapsed % duration) / duration;
        const point = path.getPointAtLength(progress * pathLength);

        marker.setAttribute('cx', point.x);
        marker.setAttribute('cy', point.y);

        requestAnimationFrame(animateTrack);
    }

    // Consumo dinâmico da API de Clima (Joinville, SC)
    async function carregarClimaJoinville() {
        try {
            const response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-26.3045&longitude=-48.8487&current_weather=true');
            if (!response.ok) throw new Error('Falha ao obter dados meteorológicos');
            const data = await response.json();
            
            const temp = Math.round(data.current_weather.temperature);
            const vento = Math.round(data.current_weather.windspeed);
            const dirGraus = data.current_weather.winddirection;
            const codigoTempo = data.current_weather.weathercode;
            
            document.getElementById('clima-temp').textContent = `${temp}°C`;
            document.getElementById('clima-vento').textContent = `${vento} km/h`;
            document.getElementById('clima-direcao').textContent = obterDirecaoVento(dirGraus);
            document.getElementById('clima-condicao').textContent = traduzirCodigoClima(codigoTempo);
            document.getElementById('clima-data').textContent = 'Hoje às ' + new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        } catch (erro) {
            console.error('Erro na API de Clima:', erro);
            document.getElementById('clima-temp').textContent = '--';
            document.getElementById('clima-condicao').textContent = 'Indisponível';
            document.getElementById('clima-data').textContent = 'Sem conexão com a API';
        }
    }

    function traduzirCodigoClima(code) {
        if (code === 0) return 'Céu Limpo';
        if (code >= 1 && code <= 3) return 'Parcialmente Nublado';
        if (code >= 45 && code <= 48) return 'Névoa / Cerração';
        if (code >= 51 && code <= 67) return 'Chuva Leve / Garoa';
        if (code >= 80 && code <= 82) return 'Pancadas de Chuva';
        return 'Nublado';
    }

    function obterDirecaoVento(graus) {
        if (graus >= 337.5 || graus < 22.5) return 'Norte (N)';
        if (graus >= 22.5 && graus < 67.5) return 'Nordeste (NE)';
        if (graus >= 67.5 && graus < 112.5) return 'Leste (L)';
        if (graus >= 112.5 && graus < 157.5) return 'Sudeste (SE)';
        if (graus >= 157.5 && graus < 202.5) return 'Sul (S)';
        if (graus >= 202.5 && graus < 247.5) return 'Sudoeste (SO)';
        if (graus >= 247.5 && graus < 292.5) return 'Oeste (O)';
        return 'Noroeste (NO)';
    }

    document.addEventListener('DOMContentLoaded', () => {
        carregarClimaJoinville();
        requestAnimationFrame(animateTrack);
    });
</script>
</body>
</html>