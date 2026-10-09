<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Início</title>
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
        .action-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #ffffff;
        }
        .action-card:hover {
            transform: translateY(-4px);
            border-color: var(--brand-color);
            box-shadow: 0 12px 24px rgba(255, 102, 0, 0.08) !important;
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
        .card-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background-color: #fff3eb;
            color: var(--brand-color);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white d-flex align-items-center gap-2" href="home.php">
                <span>+ Já.Ismaga</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3 fw-semibold"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container my-5">
        <div class="p-4 p-md-5 mb-4 bg-white rounded-4 shadow-sm border border-light-subtle">
            
            <div class="border-bottom pb-4 mb-4">
                <h1 class="display-6 fw-bold text-dark m-0">
                    Bem-vindo(a), <span style="color: #ff6600;"><?= htmlspecialchars($nomeUsuario); ?></span>! 
                </h1>
                <p class="fs-6 text-muted m-0 mt-2">
                    Selecione um dos módulos abaixo ou utilize o menu superior para gerenciar os recursos da plataforma.
                </p>
            </div>
            
            <div class="row g-4 mt-1">
                        <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card action-card h-100 shadow-sm text-center p-4">
                        <div class="card-icon-box mx-auto">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Usuários</h5>
                        <p class="small text-muted mb-4">Gestão de contas e permissões de acesso</p>
                        <a href="usuarios.php" class="btn btn-brand btn-sm rounded-3 w-100 mt-auto shadow-sm">
                            <i class="bi bi-arrow-right-short fs-5 align-middle me-1"></i>Acessar
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card action-card h-100 shadow-sm text-center p-4">
                        <div class="card-icon-box mx-auto">
                            <i class="bi bi-train-front-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Trens</h5>
                        <p class="small text-muted mb-4">Controle e frota das locomotivas</p>
                        <a href="trens.php" class="btn btn-brand btn-sm rounded-3 w-100 mt-auto shadow-sm">
                            <i class="bi bi-arrow-right-short fs-5 align-middle me-1"></i>Acessar
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card action-card h-100 shadow-sm text-center p-4">
                        <div class="card-icon-box mx-auto">
                            <i class="bi bi-map-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Rotas</h5>
                        <p class="small text-muted mb-4">Mapeamento, trajetos e durações</p>
                        <a href="rotas.php" class="btn btn-brand btn-sm rounded-3 w-100 mt-auto shadow-sm">
                            <i class="bi bi-arrow-right-short fs-5 align-middle me-1"></i>Acessar
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card action-card h-100 shadow-sm text-center p-4">
                        <div class="card-icon-box mx-auto">
                            <i class="bi bi-cpu-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Sensores</h5>
                        <p class="small text-muted mb-4">Telemetria e monitorização em tempo real</p>
                        <a href="sensores.php" class="btn btn-brand btn-sm rounded-3 w-100 mt-auto shadow-sm">
                            <i class="bi bi-arrow-right-short fs-5 align-middle me-1"></i>Acessar
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">
            &copy; <?= date('Y'); ?> <strong>+ Já.Ismaga</strong>. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>