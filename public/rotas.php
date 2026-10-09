<?php
session_start();

// Controle de Autenticação: Exige login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);
$isAdmin     = ($_SESSION['usuario_tipo'] ?? '') === 'admin';

$listaRotas = [];
try {
    // Consulta buscando a rota e as informações do trem vinculado (LEFT JOIN)
    $sql = "SELECT r.*, t.nome AS nome_trem, t.modelo AS modelo_trem 
            FROM rotas r 
            LEFT JOIN trens t ON r.trem_id = t.id 
            ORDER BY r.id DESC";
    $stmt = $pdo->query($sql);
    $listaRotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar rotas: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro ao carregar a lista de rotas.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Gestão de Rotas</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container.fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white" href="home.php">+ Já.Ismaga</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php' || $paginaAtual == 'rota-form.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%);">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= htmlspecialchars($_SESSION['mensagem_sucesso']); unset($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= htmlspecialchars($_SESSION['mensagem_erro']); unset($_SESSION['mensagem_erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background-color: rgb(255, 249, 240);">
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-map-fill me-2" style="color: #ff6600;"></i>Gestão de Rotas</h2>
            <?php if ($isAdmin): ?>
                <a href="rota-form.php" class="btn text-white fw-bold shadow-sm rounded-3" style="background-color: #ff6600 !important; border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Nova Rota
                </a>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background-color: rgb(255, 249, 240);">
            <div class="card-body p-4">
                <p class="text-muted">Consulte e acompanhe as rotas cadastradas e os trens vinculados:</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Rota</th>
                                <th>Trajeto (Origem &rarr; Destino)</th>
                                <th>Distância</th>
                                <th>Tempo Previsto</th>
                                <th>Trem Vinculado</th>
                                <th>Criado em</th>
                                <?php if ($isAdmin): ?>
                                    <th style="width: 120px;" class="text-center">Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaRotas)): ?>
                                <?php foreach ($listaRotas as $r): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary">#<?= $r['id']; ?></td>
                                        <td>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($r['nome_rota']); ?></span>
                                            <?php if (!empty($r['descricao'])): ?>
                                                <br><small class="text-muted d-inline-block text-truncate" style="max-width: 200px;"><?= htmlspecialchars($r['descricao']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($r['origem']); ?> &rarr; <?= htmlspecialchars($r['destino']); ?></td>
                                        <td><span class="badge bg-light text-dark border"><?= number_format($r['distancia_km'], 2, ',', '.'); ?> km</span></td>
                                        <td><i class="bi bi-clock me-1 text-muted"></i><?= htmlspecialchars($r['tempo_previsto']); ?></td>
                                        <td>
                                            <?php if ($r['nome_trem']): ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-train-front me-1"></i><?= htmlspecialchars($r['nome_trem']); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Nenhum trem</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($r['created_at'])); ?></small></td>
                                        
                                        <?php if ($isAdmin): ?>
                                            <td class="text-center">
                                                <a href="rota-form.php?id=<?= $r['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Excluir"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalExcluirRota" 
                                                        data-id="<?= $r['id']; ?>" 
                                                        data-nome="<?= htmlspecialchars($r['nome_rota']); ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '8' : '7'; ?>" class="text-center text-muted py-4">Nenhuma rota cadastrada no sistema.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Exclusão -->
    <div class="modal fade" id="modalExcluirRota" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fs-5 mb-1">Tem certeza que deseja excluir a rota <strong id="nomeRotaModal"></strong>?</p>
                    <small class="text-muted">Esta ação removerá o percurso do sistema.</small>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarExclusaoRota" href="#" class="btn btn-danger px-4 rounded-3 fw-bold">Excluir Rota</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga. Todos os direitos reservados.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalExcluir = document.getElementById('modalExcluirRota');
        if (modalExcluir) {
            modalExcluir.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const rotaId = button.getAttribute('data-id');
                const rotaNome = button.getAttribute('data-nome');

                document.getElementById('nomeRotaModal').textContent = rotaNome;
                document.getElementById('btnConfirmarExclusaoRota').href = 'rota-deletar.php?id=' + rotaId;
            });
        }
    </script>
</body>
</html>