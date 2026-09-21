<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'];
$paginaAtual = basename($_SERVER['PHP_SELF']);
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
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 me-4 text-dark" href="home.php">
                + Já.Ismaga
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">
                            Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">
                            Usuários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'trens.php') ? 'fw-bold active' : ''; ?>" href="trens.php">
                            Trens
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">
                            Rotas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">
                            Sensores
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="p-5 mb-4 bg-white rounded-4 shadow-sm border">
            <h1 class="display-6 fw-bold text-dark mb-3">Painel de Controlo</h1>
            <p class="col-md-10 fs-5 text-muted mb-4">
                Selecione uma das opções no menu superior para gerir Usuários, Trens, Rotas ou Sensores.
            </p>
            
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm bg-light text-center p-3">
                        <h5 class="fw-bold">Usuários</h5>
                        <p class="small text-muted">Gestão de contas e permissões</p>
                        <a href="usuarios.php" class="btn btn-warning btn-sm text-white fw-bold">Aceder</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm bg-light text-center p-3">
                        <h5 class="fw-bold">Trens</h5>
                        <p class="small text-muted">Controlo da frota ferroviária</p>
                        <a href="trens.php" class="btn btn-warning btn-sm text-white fw-bold">Aceder</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm bg-light text-center p-3">
                        <h5 class="fw-bold">Rotas</h5>
                        <p class="small text-muted">Mapeamento e trajetos</p>
                        <a href="rotas.php" class="btn btn-warning btn-sm text-white fw-bold">Aceder</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm bg-light text-center p-3">
                        <h5 class="fw-bold">Sensores</h5>
                        <p class="small text-muted">Monitorização em tempo real</p>
                        <a href="sensores.php" class="btn btn-warning btn-sm text-white fw-bold">Aceder</a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">
            &copy; <?= date('Y'); ?> Já Ismaga.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>