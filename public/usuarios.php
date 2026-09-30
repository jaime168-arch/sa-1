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
<<<<<<< HEAD
=======
    // Busca id, nome, email, tipo e ativo da tabela usuarios
>>>>>>> 8c8ed08bc29b4fd53503f53b2cb9e9833ae77439
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
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php' || $paginaAtual == 'sensor-form.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%);">
                     <span class="text-dark">  Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong> </span>
                     <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3">
                  <i class="bi bi-box-arrow-right me-1"></i> Sair</a>
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
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-people-fill me-2"></i>Gestão de Usuários</h2>
            <?php if ($isAdmin): ?>
                <a href="usuario-form.php" class="btn btn-warning text-white fw-bold shadow-sm" style="background-color: #ff6600 !important; border: none;">
                    <i class="bi bi-person-plus-fill me-1"></i> Novo Usuário
                </a>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background-color: rgb(255, 249, 240);">
            <div class="card-body p-4">
                <p class="text-muted">Lista de utilizadores registados no sistema:</p>
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
                                        <td><?= htmlspecialchars($u['nome']); ?></td>
                                        <td><?= htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($u['tipo'] ?? '') === 'admin' ? 'danger' : 'info'; ?> text-capitalize">
                                                <?= htmlspecialchars($u['tipo'] ?? 'operador'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ((int)($u['ativo'] ?? 1) === 1): ?>
                                                <span class="badge bg-success">Ativo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <?php if ($isAdmin): ?>
                                            <td class="text-center">
                                                <!-- Botão Editar -->
                                                <a href="usuario-form.php?id=<?= $u['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <!-- Botão Excluir com a classe "btn-deletar-usuario" para o JS capturar -->
                                                <?php if ((int)$u['id'] !== (int)$_SESSION['usuario_id'] && (int)$u['id'] !== 1): ?>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger btn-deletar-usuario" 
                                                            title="Excluir"
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

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Importação do arquivo JS corrigido -->
    <script src="../scripts/usuario-excluir.js"></script>
</body>
</html>