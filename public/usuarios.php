<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);
$isAdmin     = ($_SESSION['usuario_tipo'] ?? '') === 'admin';

$listaUsuarios = [];
try {
    $stmt = $pdo->query("SELECT id, nome, email, tipo, ativo FROM usuarios ORDER BY id DESC");
    $listaUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar utilizadores: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro ao carregar a lista de utilizadores.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Gestão de Usuários</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        :root {
            --brand-color: #ff6600;
            --brand-hover: #e05500;
            --bg-page: #f8fafc;
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
            transition: all 0.2s ease;
        }
        .btn-brand:hover {
            background-color: var(--brand-hover);
            border-color: var(--brand-hover);
            color: #ffffff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR DA APLICAÇÃO -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
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
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3 fw-semibold"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="container my-5">
        
        <!-- MENSAGENS DE ALERTA -->
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= htmlspecialchars($_SESSION['mensagem_sucesso']); unset($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= htmlspecialchars($_SESSION['mensagem_erro']); unset($_SESSION['mensagem_erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>

        <!-- CABEÇALHO DO MÓDULO -->
        <div class="d-flex justify-content-between align-items-center mb-4 p-4 rounded-4 bg-white shadow-sm border border-light-subtle">
            <div>
                <h2 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill" style="color: #ff6600;"></i> Gestão de Usuários
                </h2>
                <small class="text-muted">Gerencie contas, perfis de acesso e estados das contas de utilizadores.</small>
            </div>
            <?php if ($isAdmin): ?>
                <a href="usuario-form.php" class="btn btn-brand rounded-3 px-3 shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Novo Usuário
                </a>
            <?php endif; ?>
        </div>

        <!-- TABELA DE USUÁRIOS -->
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Estado</th>
                                <?php if ($isAdmin): ?>
                                    <th style="width: 140px;" class="text-center">Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaUsuarios)): ?>
                                <?php foreach ($listaUsuarios as $u): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary">#<?= $u['id']; ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($u['nome']); ?></td>
                                        <td><?= htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <?php if (($u['tipo'] ?? '') === 'admin'): ?>
                                                <span class="badge bg-danger">Administrador</span>
                                            <?php elseif (($u['tipo'] ?? '') === 'supervisor'): ?>
                                                <span class="badge bg-warning text-dark">Supervisor</span>
                                            <?php elseif (($u['tipo'] ?? '') === 'operador'): ?>
                                                <span class="badge bg-info text-dark">Operador</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= htmlspecialchars($u['tipo'] ?: 'Comum'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ((int)($u['ativo'] ?? 1) === 1): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Ativo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <?php if ($isAdmin): ?>
                                            <td class="text-center">
                                                <a href="usuario-form.php?id=<?= $u['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <?php if ((int)$u['id'] !== (int)$_SESSION['usuario_id'] && (int)$u['id'] !== 1): ?>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Excluir"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalExcluir" 
                                                            data-id="<?= $u['id']; ?>" 
                                                            data-nome="<?= htmlspecialchars($u['nome']); ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Protegido">
                                                        <i class="bi bi-shield-lock"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '6' : '5'; ?>" class="text-center text-muted py-4">Nenhum utilizador registado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="modalExcluirLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fs-5 mb-1">Tem certeza que deseja excluir o utilizador <strong id="nomeUsuarioModal"></strong>?</p>
                    <small class="text-muted">Esta ação é permanente e removerá o registo da base de dados.</small>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarExclusao" href="#" class="btn btn-danger px-4 rounded-3 fw-bold">Excluir Registro</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> <strong>+ Já.Ismaga</strong>. Todos os direitos reservados.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalExcluir = document.getElementById('modalExcluir');
        if (modalExcluir) {
            modalExcluir.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-nome');

                document.getElementById('nomeUsuarioModal').textContent = userName;
                document.getElementById('btnConfirmarExclusao').href = 'usuario-deletar.php?id=' + userId;
            });
        }
    </script>
</body>
</html>