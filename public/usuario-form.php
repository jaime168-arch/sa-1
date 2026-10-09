<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado: Apenas administradores podem gerenciar usuários.";
    header("Location: usuarios.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

$usuarioEdit = [
    'id'    => '',
    'nome'  => '',
    'email' => '',
    'tipo'  => 'operador', 
    'ativo' => 1        
];
$modoEdicao = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT id, nome, email, tipo, ativo FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dados) {
            $usuarioEdit = $dados;
            $modoEdicao = true;
        } else {
            $_SESSION['mensagem_erro'] = "Usuário não encontrado.";
            header("Location: usuarios.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro ao carregar usuário: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro ao carregar dados do usuário.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $modoEdicao ? 'Editar Usuário #' . $usuarioEdit['id'] : 'Novo Usuário'; ?></title>
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
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php' || $paginaAtual == 'sensor-form.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
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
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <!-- MENSAGENS DE ALERTA -->
                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($_SESSION['mensagem_erro']); unset($_SESSION['mensagem_erro']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= htmlspecialchars($_SESSION['mensagem_sucesso']); unset($_SESSION['mensagem_sucesso']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <!-- CARD FORMULÁRIO -->
                <div class="card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header bg-transparent border-bottom p-4 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                            <i class="bi bi-person-gear" style="color: #ff6600;"></i>
                            <?= $modoEdicao ? 'Editar Usuário' : 'Cadastrar Novo Usuário'; ?>
                        </h3>
                        <a href="usuarios.php" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar à Lista
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <p class="text-muted small mb-4">Preencha as informações abaixo para <?= $modoEdicao ? 'atualizar a conta do' : 'cadastrar um novo'; ?> utilizador no sistema.</p>

                        <form action="usuario-salvar.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuarioEdit['id']); ?>">

                            <div class="row g-3 mb-3">
                                <!-- NOME COMPLETO -->
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold text-dark">Nome Completo <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control border-start-0 rounded-end-3" id="nome" name="nome" value="<?= htmlspecialchars($usuarioEdit['nome']); ?>" required placeholder="Digite o nome completo">
                                    </div>
                                </div>

                                <!-- E-MAIL -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold text-dark">Endereço de E-mail <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control border-start-0 rounded-end-3" id="email" name="email" value="<?= htmlspecialchars($usuarioEdit['email']); ?>" required placeholder="nome@exemplo.com">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- PERFIL DE ACESSO -->
                                <div class="col-md-6">
                                    <label for="tipo" class="form-label fw-semibold text-dark">Perfil de Acesso <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-shield-lock"></i></span>
                                        <select class="form-select border-start-0 rounded-end-3" id="tipo" name="tipo" required>
                                            <option value="admin" <?= ($usuarioEdit['tipo'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                            <option value="supervisor" <?= ($usuarioEdit['tipo'] == 'supervisor') ? 'selected' : ''; ?>>Supervisor</option>
                                            <option value="operador" <?= ($usuarioEdit['tipo'] == 'operador') ? 'selected' : ''; ?>>Operador</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- STATUS DA CONTA -->
                                <div class="col-md-6">
                                    <label for="ativo" class="form-label fw-semibold text-dark">Status da Conta <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="ativo" name="ativo" required>
                                        <option value="1" <?= ($usuarioEdit['ativo'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="0" <?= ($usuarioEdit['ativo'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <!-- SENHA -->
                                <div class="col-md-6">
                                    <label for="senha" class="form-label fw-semibold text-dark">
                                        Senha <?= $modoEdicao ? '<small class="text-muted fw-normal">(deixe em branco para não alterar)</small>' : '<span class="text-danger">*</span>'; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control border-start-0 rounded-end-3" id="senha" name="senha" <?= $modoEdicao ? '' : 'required'; ?> placeholder="••••••••">
                                    </div>
                                </div>

                                <!-- CONFIRMAR SENHA -->
                                <div class="col-md-6">
                                    <label for="confirmar_senha" class="form-label fw-semibold text-dark">
                                        Confirmar Senha <?= $modoEdicao ? '' : '<span class="text-danger">*</span>'; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" class="form-control border-start-0 rounded-end-3" id="confirmar_senha" name="confirmar_senha" <?= $modoEdicao ? '' : 'required'; ?> placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- BOTÕES DE AÇÃO -->
                            <div class="d-flex justify-content-end gap-3 align-items-center">
                                <a href="usuarios.php" class="btn btn-secondary px-4 fw-bold rounded-3">Cancelar</a>
                                <button type="submit" class="btn btn-brand px-4 rounded-3 shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> Salvar Usuário
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> <strong>+ Já.Ismaga</strong>. Todos os direitos reservados.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>