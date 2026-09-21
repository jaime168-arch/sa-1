<?php
session_start();

// Proteção da página: verifica se o utilizador está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'];
$paginaAtual = basename($_SERVER['PHP_SELF']);
$pageTitle   = "Já Ismaga - Cadastro de Utilizador";

// Conexão com o banco de dados (se disponível)
require_once __DIR__ . '/../config/conexao.php';

// Dados padrões do utilizador
$usuario = [
    'id'             => '',
    'nome'           => '',
    'email'          => '',
    'perfil'         => '',
    'status_usuario' => 'ativo'
];

// Se receber ID via GET, busca os dados para Edição
$id = $_GET['id'] ?? null;
if ($id && isset($pdo)) {
    $stmt = $pdo->prepare("SELECT id, nome, email, perfil, status_usuario FROM usuarios WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $usuarioCarregado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuarioCarregado) {
        $usuario = $usuarioCarregado;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar Padronizada -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 me-4 text-dark" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'trens.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-person-fill-gear fs-2 text-warning me-3" style="color: #ff6600 !important;"></i>
                            <h3 class="fw-bold text-dark m-0">
                                <?= !empty($usuario['id']) ? 'Editar Utilizador' : 'Cadastrar Utilizador'; ?>
                            </h3>
                        </div>

                        <form id="usuarioForm" action="usuario-salvar.php" method="POST">
                            
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="nome" class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required placeholder="Ex: João Silva">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required placeholder="Ex: joao@ismaga.com">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="senha" class="form-label fw-semibold">
                                        Senha <?= empty($usuario['id']) ? '<span class="text-danger">*</span>' : '<small class="text-muted">(deixe em branco para manter)</small>'; ?>
                                    </label>
                                    <input type="password" class="form-control rounded-3" id="senha" name="senha" <?= empty($usuario['id']) ? 'required' : ''; ?> placeholder="Digite a senha">
                                </div>
                                <div class="col-md-6">
                                    <label for="perfil" class="form-label fw-semibold">Perfil de Acesso <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="perfil" name="perfil" required>
                                        <option value="" disabled <?= empty($usuario['perfil']) ? 'selected' : ''; ?>>Selecione o perfil...</option>
                                        <option value="admin" <?= ($usuario['perfil'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="operador" <?= ($usuario['perfil'] == 'operador') ? 'selected' : ''; ?>>Operador de Campo</option>
                                        <option value="visualizador" <?= ($usuario['perfil'] == 'visualizador') ? 'selected' : ''; ?>>Visualizador / Passageiro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="statusUsuario" class="form-label fw-semibold">Status do Cadastro <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="statusUsuario" name="status_usuario" required>
                                        <option value="ativo" <?= ($usuario['status_usuario'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="inativo" <?= ($usuario['status_usuario'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                                        <option value="bloqueado" <?= ($usuario['status_usuario'] == 'bloqueado') ? 'selected' : ''; ?>>Bloqueado</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="usuarios.php" class="btn btn-secondary px-4 fw-bold rounded-3">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold rounded-3 shadow-sm" style="background-color: #ff6600 !important; border: none;">
                                    Salvar Utilizador
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Rodapé Padronizado -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>