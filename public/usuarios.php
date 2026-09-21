<?php
// Configurações e definições da página
$pageTitle = "Perfil e Usuários - Já Ismaga";

// Mock de dados do usuário logado e histórico
$usuarioLogado = [
    'id' => '88291',
    'nome' => 'João Silva',
    'tipo' => 'Passageiro',
    'nivel' => 'Premium',
    'ultimo_acesso' => 'Hoje, 09:45',
    'pontos' => '2.450'
];

$atividades = [
    [
        'nome' => 'Recarga de Cartão Digital',
        'data' => '13/05/2026',
        'status' => 'Concluído'
    ],
    [
        'nome' => 'Acesso Estação Central',
        'data' => '12/05/2026',
        'status' => 'Concluído'
    ],
    [
        'nome' => 'Suporte via Chat',
        'data' => '10/05/2026',
        'status' => 'Em Análise'
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
            <a class="navbar-brand fw-bold" href="../index.php">+ Já.Ismaga</a>
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
        
        <!-- Header Profile Section -->
        <header class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <div>
                <h2 class="fw-bold text-dark m-0">Olá, <?= htmlspecialchars($usuarioLogado['tipo']); ?>!</h2>
                <p class="text-muted small m-0">Bem-vindo à sua central de controlo ferroviário.</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block">
                    <p class="mb-0 fw-bold"><?= htmlspecialchars($usuarioLogado['nome']); ?></p>
                    <small class="text-muted">ID: #<?= htmlspecialchars($usuarioLogado['id']); ?></small>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($usuarioLogado['nome']); ?>&background=212529&color=fff" class="rounded-circle shadow-sm" width="48" height="48" alt="Avatar">
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <p class="text-muted small mb-1">Nível de Conta</p>
                    <h4 class="fw-bold text-dark m-0"><?= htmlspecialchars($usuarioLogado['nivel']); ?></h4>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <p class="text-muted small mb-1">Último Acesso</p>
                    <h4 class="fw-bold text-dark m-0"><?= htmlspecialchars($usuarioLogado['ultimo_acesso']); ?></h4>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <p class="text-muted small mb-1">Pontos de Fidelidade</p>
                    <h4 class="fw-bold text-dark m-0" id="fidelidade-pontos"><?= htmlspecialchars($usuarioLogado['pontos']); ?> pts</h4>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="p-4 bg-white rounded shadow-sm mb-4 border-0">
            <h5 class="fw-bold text-dark mb-2">Carteira Digital</h5>
            <p class="text-muted small">Adicione créditos e converta viagens em recompensas operacionais na malha Já Ismaga.</p>
            <button class="btn btn-warning text-white fw-bold btn-sm px-4 py-2" id="btn-recarga-rapida">
                Recarga Rápida (+500 pts)
            </button>
        </div>

        <!-- History Table -->
        <div class="card border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-dark">Histórico de Atividades</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabela-atividades">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="ps-4">Atividade</th>
                            <scope="col">Data</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end pe-4">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($atividades)): ?>
                            <?php foreach ($atividades as $atividade): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold"><?= htmlspecialchars($atividade['nome']); ?></td>
                                    <td class="text-muted"><?= htmlspecialchars($atividade['data']); ?></td>
                                    <td>
                                        <?php if ($atividade['status'] === 'Concluído'): ?>
                                            <span class="badge bg-success">Concluído</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><?= htmlspecialchars($atividade['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary px-3 btn-detalhes" data-bs-toggle="modal" data-bs-target="#modalDetalhesAtividade" data-nome="<?= htmlspecialchars($atividade['nome']); ?>" data-data="<?= htmlspecialchars($atividade['data']); ?>" data-status="<?= htmlspecialchars($atividade['status']); ?>">Detalhes</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Nenhum registo encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal de Detalhes -->
    <div class="modal fade" id="modalDetalhesAtividade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-dark">Detalhes da Atividade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Descrição do Serviço</label>
                        <span id="modal-nome" class="fw-bold fs-5 text-dark">-</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="text-muted small d-block">Data do Evento</label>
                            <span id="modal-data" class="fw-semibold text-secondary">-</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Status Atual</label>
                            <div id="modal-status-container">-</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Fechar Registro</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modalDetalhesAtividade');
            if (modal) {
                modal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget;
                    document.getElementById('modal-nome').textContent = button.getAttribute('data-nome');
                    document.getElementById('modal-data').textContent = button.getAttribute('data-data');
                    document.getElementById('modal-status-container').textContent = button.getAttribute('data-status');
                });
            }
        });
    </script>
</body>
</html>