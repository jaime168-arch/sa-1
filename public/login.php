<?php
session_start();
$pageTitle = "Já Ismaga - Login";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        :root {
            --brand-orange: #ff6600;
            --brand-orange-hover: #e05500;
        }

        body, html {
            min-height: 100vh;
            background-color: rgb(255, 246, 230);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Navbar elegante */
        .navbar-ismaga-login {
            background-color: var(--brand-orange) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Card refinado mantendo a estrutura original */
        .card-login-custom {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06) !important;
        }

        /* Botão estilizado */
        .btn-login-custom {
            background-color: var(--brand-orange) !important;
            border-color: var(--brand-orange) !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-login-custom:hover {
            background-color: var(--brand-orange-hover) !important;
            border-color: var(--brand-orange-hover) !important;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="main-container flex-grow-1">
        
        <!-- NAVBAR ORIGINAL MANTIDA COM AJUSTE DE SOMBRA E PROPORÇÃO -->
        <nav class="navbar navbar-ismaga-login py-2">
            <div class="container d-flex justify-content-center align-items-center">
                <a class="navbar-brand m-0 d-flex align-items-center" href="../index.php">
                    <img src="../assets/img_2.png" 
                         alt="Logo Já Ismaga" 
                         style="max-height: 75px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));"
                         onerror="this.style.display='none'; document.getElementById('nav-fallback-text').style.display='inline-block';">
                    
                    <span id="nav-fallback-text" class="fw-bold fs-4 text-white" style="display: none;">
                        + Já.Ismaga
                    </span>
                </a>
            </div>
        </nav>

        <!-- MANTIDA A ESTRUTURA E ESPAÇAMENTO ORIGINAL -->
        <div class="login-wrapper my-5">
            <div class="container">
                <div class="row justify-content-center w-100 m-0">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        
                        <div class="card card-login-custom border-0 p-3 p-md-4 bg-white">
                            <div class="card-body">
                                
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold text-dark m-0">Login</h2>
                                    <p class="text-muted small mt-1">Acesse o sistema ferroviário</p>
                                </div>

                                <!-- ALERTAS ORIGINAIS -->
                                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                        <?= htmlspecialchars($_SESSION['mensagem_erro']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['mensagem_erro']); ?>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        <?= htmlspecialchars($_SESSION['mensagem_sucesso']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['mensagem_sucesso']); ?>
                                <?php endif; ?>

                                <!-- FORMULÁRIO COM MESMOS CAMPOS E ATRIBUTOS -->
                                <form id="loginForm" action="autenticar.php" method="POST">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold text-dark">E-mail</label>
                                        <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="exemplo@gmail.com" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold text-dark">Senha</label>
                                        <input type="password" class="form-control rounded-3" id="password" name="senha" placeholder="Digite sua senha" required>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-login-custom">Entrar</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/usuario-form.js"></script> 
</body>
</html>