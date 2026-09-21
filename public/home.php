<?php
session_start();

$pageTitle = "Dashboard Operacional - Já Ismaga";

// Mock de dados para os cartões de estatísticas
$estatisticas = [
    'trens_em_operacao' => 12,
    'rotas_ativas'     => 4,
    'sensores_online'   => 28,
    'alertas_pendentes' => 2
];

// Mock de alertas recentes capturados pelos sensores
$alertasRecentes = [
    [
        'sensor'   => 'SEN-ULTRA-02',
        'local'    => 'Trem 101 - Linha Verde',
        'mensagem' => 'Proximidade abaixo do limite de segurança (1.2m)',
        'tipo'     => 'danger',
        'hora'     => '10:42'
    ],
    [
        'sensor'   => 'SEN-PRES-05',
        'local'    => 'Estação Central - Via 2',
        'mensagem' => 'Presença detectada na área de recolha fora de horário',
        'tipo'     => 'warning',
        'hora'     => '09:15'
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <!-- Primary Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primaryNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container mb-5">
        
        <!-- Welcome Banner -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold text-dark mb-1">Visão Geral da Malha</h2>
                <p class="text-muted small m-0">Acompanhamento em tempo real das rotas, trens e sensores IoT.</p>
            </div>
            <div>
                <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">
                    ● Sistema Operacional
                </span>
            </div>
        </div>

        <!-- Feedback Messages -->
        <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?= htmlspecialchars($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>

        <!-- Stat Cards Grid -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-3 h-100 border-start border-4 border-primary">
                    <p class="text-muted small mb-1">Trens em Operação</p>
                    <h3 class="fw-bold text-dark m-0"><?= $estatisticas['trens_em_operacao']; ?></h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-3 h-100 border-start border-4 border-info">
                    <p class="text-muted small mb-1">Rotas Ativas</p>
                    <h3 class="fw-bold text-dark m-0"><?= $estatisticas['rotas_ativas']; ?></h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-3 h-100 border-start border-4 border-success">
                    <p class="text-muted small mb-1">Sensores Online (ESP32)</p>
                    <h3 class="fw-bold text-dark m-0"><?= $estatisticas['sensores_online']; ?></h3>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm p-3 h-100 border-start border-4 border-danger">
                    <p class="text-muted small mb-1">Alertas Pendentes</p>
                    <h3 class="fw-bold text-dark m-0"><?= $estatisticas['alertas_pendentes']; ?></h3>
                </div>
            </div>
        </div>

        <!-- Actions & Telemetry Row -->
        <div class="row g-4 mb-4">
            <!-- Quick Actions -->
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold text-dark m-0">Ações Rápidas</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-grid gap-2">
                            <a href="sensor-form.php" class="btn btn-warning text-white fw-bold py-2">
                                + Cadastrar Novo Sensor IoT
                            </a>
                            <a href="trem-form.php" class="btn btn-dark fw-bold py-2">
                                + Adicionar Trem à Frota
                            </a>
                            <a href="rota-form.php" class="btn btn-outline-secondary fw-bold py-2">
                                + Mapear Nova Rota
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Telemetry Alerts -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark m-0">Alertas Recentes do Sistema</h5>
                        <a href="sensores.php" class="small text-decoration-none">Ver todos os sensores →</a>
                    </div>
                    <div class="card-body pt-0">
                        <?php if (!empty($alertasRecentes)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($alertasRecentes as $alerta): ?>
                                    <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-<?= $alerta['tipo']; ?>"><?= htmlspecialchars($alerta['sensor']); ?></span>
                                                <strong class="text-dark small"><?= htmlspecialchars($alerta['local']); ?></strong>
                                            </div>
                                            <p class="mb-0 small text-muted"><?= htmlspecialchars($alerta['mensagem']); ?></p>
                                        </div>
                                        <span class="small text-muted ms-3"><?= htmlspecialchars($alerta['hora']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted small my-3 text-center">Nenhum alerta registrado no momento.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>