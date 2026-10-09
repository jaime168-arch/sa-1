<?php
session_start();

// Controle de Acesso: Exige autenticação
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);
$isAdmin     = ($_SESSION['usuario_tipo'] ?? '') === 'admin';

$listaTrens = [];
try {
    // Consulta buscando os trens e o NOME do usuário responsável
    $sql = "SELECT t.*, u.nome AS nome_responsavel 
            FROM trens t 
            LEFT JOIN usuarios u ON t.usuario_id = u.id 
            ORDER BY t.id DESC";
    $stmt = $pdo->query($sql);
    $listaTrens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar trens: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro ao carregar a lista de trens.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Gestão de Trens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container.fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
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
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= htmlspecialchars($_SESSION['mensagem_sucesso']); unset($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= htmlspecialchars($_SESSION['mensagem_erro']); unset($_SESSION['mensagem_erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3" style="background-color: rgb(255, 249, 240);">
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-train-front-fill me-2"></i>Gestão de Trens</h2>
            <?php if ($isAdmin): ?>
                <a href="trem-form.php" class="btn btn-warning text-white fw-bold shadow-sm" style="background-color: #ff6600 !important; border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Novo Trem
                </a>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background-color: rgb(255, 249, 240);">
            <div class="card-body p-4">
                <p class="text-muted">Lista de trens registados na frota:</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th>Nome do Trem</th>
                                <th>Modelo</th>
                                <th>Capacidade</th>
                                <th>Responsável</th>
                                <th>Estado</th>
                                <?php if ($isAdmin): ?>
                                    <th style="width: 130px;" class="text-center">Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaTrens)): ?>
                                <?php foreach ($listaTrens as $t): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary">#<?= $t['id']; ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($t['nome']); ?></td>
                                        <td><?= htmlspecialchars($t['modelo']); ?></td>
                                        <td><?= (int)$t['capacidade']; ?> passageiros</td>
                                        <td>
                                            <?php if ($t['nome_responsavel']): ?>
                                                <span class="badge bg-light text-dark border"><i class="bi bi-person-badge me-1"></i><?= htmlspecialchars($t['nome_responsavel']); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Sem responsável</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($t['status'] === 'ativo'): ?>
                                                <span class="badge bg-success">Ativo</span>
                                            <?php elseif ($t['status'] === 'manutencao'): ?>
                                                <span class="badge bg-warning text-dark">Manutenção</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <?php if ($isAdmin): ?>
                                            <td class="text-center">
                                                <a href="trem-form.php?id=<?= $t['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Excluir"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalExcluirTrem" 
                                                        data-id="<?= $t['id']; ?>" 
                                                        data-nome="<?= htmlspecialchars($t['nome']); ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '7' : '6'; ?>" class="text-center text-muted py-4">Nenhum trem cadastrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Exclusão -->
    <div class="modal fade" id="modalExcluirTrem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fs-5 mb-1">Tem certeza que deseja excluir o trem <strong id="nomeTremModal"></strong>?</p>
                    <small class="text-muted">Esta ação não poderá ser desfeita.</small>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarExclusaoTrem" href="#" class="btn btn-danger px-4 rounded-3 fw-bold">Excluir Trem</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalExcluir = document.getElementById('modalExcluirTrem');
        if (modalExcluir) {
            modalExcluir.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const tremId = button.getAttribute('data-id');
                const tremNome = button.getAttribute('data-nome');

                document.getElementById('nomeTremModal').textContent = tremNome;
                document.getElementById('btnConfirmarExclusaoTrem').href = 'trem-deletar.php?id=' + tremId;
            });
        }
    </script>
</body>
</html>