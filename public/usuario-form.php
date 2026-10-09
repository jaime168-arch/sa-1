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

$usuarioEdit = [
    'id'     => '',
    'nome'   => '',
    'email'  => '',
    'tipo'   => 'operador', 
    'ativo'  => 1        
];
$modoEdicao = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT id, nome, email, tipo, ativo FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $usuarioEdit = $dados;
            $modoEdicao = true;
        }
    } catch (PDOException $e) {
        error_log("Erro ao carregar usuário: " . $e->getMessage());
    }
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $modoEdicao ? 'Editar' : 'Novo'; ?> Usuário</title>
    
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
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Voltar ao início <img src="https://images.icon-icons.com/3162/PNG/512/left_return_arrow_icon_193335.png" alt="Início" width="20" height="20"></a></li>                </ul>
                <div class="d-flex align-items-center gap-3" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%);">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        
        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-person-plus-fill me-2"></i><?= $modoEdicao ? 'Editar Usuário' : 'Novo Usuário'; ?>
            </h2>
            <a href="usuarios.php" class="btn btn-outline-secondary fw-semibold rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <form action="usuario-salvar.php" method="POST">
                    
                    <input type="hidden" name="id" value="<?= $usuarioEdit['id']; ?>">

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label fw-semibold text-dark">Nome Completo</label>
                            <input type="text" class="form-control rounded-3" id="nome" name="nome" value="<?= htmlspecialchars($usuarioEdit['nome']); ?>" required placeholder="Digite o nome completo">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold text-dark">Endereço de E-mail</label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= htmlspecialchars($usuarioEdit['email']); ?>" required placeholder="nome@exemplo.com">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label fw-semibold text-dark">Tipo de Conta</label>
                            <select class="form-select rounded-3" id="tipo" name="tipo" required>
                                <option value="admin" <?= ($usuarioEdit['tipo'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="operador" <?= ($usuarioEdit['tipo'] == 'operador') ? 'selected' : ''; ?>>Operador</option>
                                <option value="usuario" <?= ($usuarioEdit['tipo'] == 'usuario') ? 'selected' : ''; ?>>Usuário Comum</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ativo" class="form-label fw-semibold text-dark">Status da Conta</label>
                            <select class="form-select rounded-3" id="ativo" name="ativo" required>
                                <option value="1" <?= ($usuarioEdit['ativo'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?= ($usuarioEdit['ativo'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="senha" class="form-label fw-semibold text-dark">
                                Senha <?= $modoEdicao ? '<small class="text-muted fw-normal">(deixe em branco se não quiser alterar)</small>' : ''; ?>
                            </label>
                            <input type="password" class="form-control rounded-3" id="senha" name="senha" <?= $modoEdicao ? '' : 'required'; ?> placeholder="******">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="confirmar_senha" class="form-label fw-semibold text-dark">Confirmar Senha</label>
                            <input type="password" class="form-control rounded-3" id="confirmar_senha" name="confirmar_senha" <?= $modoEdicao ? '' : 'required'; ?> placeholder="******">
                        </div>
                    </div>

                    <hr class="my-4 text-muted">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="usuarios.php" class="btn btn-light border px-4 rounded-3">Cancelar</a>
                        <button type="submit" class="btn text-white fw-bold px-4 rounded-3" style="background-color: #ff6600 !important;">
                            <i class="bi bi-check-circle-fill me-1"></i> Salvar Usuário
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </main>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>