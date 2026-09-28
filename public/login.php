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
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <div class="main-container">
        <nav class="navbar navbar-orange navbar-ismaga py-3">
            <div class="container justify-content-center">
                <a class="navbar-brand text-white fw-bold m-0" href="../index.php">+ Já.Ismaga</a>
            </div>
        </nav>
            <div class="login-wrapper my-5">
            <div class="container">
                <div class="row justify-content-center w-100 m-0">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        
                        <div class="card shadow-lg border-0 p-4">
                            <div class="card-body">
                                
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold text-dark">Login</h2>
                                    <p class="text-muted small">Acesse o sistema ferroviário</p>
                                </div>

                                <!-- Mensagem de Erro -->
                                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($_SESSION['mensagem_erro']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['mensagem_erro']); ?>
                                <?php endif; ?>

                                <!-- Mensagem de Sucesso -->
                                <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($_SESSION['mensagem_sucesso']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['mensagem_sucesso']); ?>
                                <?php endif; ?>

                                <!-- Formulário de Login -->
                                <form id="loginForm" action="autenticar.php" method="POST">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@gmail.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Senha</label>
                                        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite sua senha" required>
                                    </div>
                                    
                                    <div class="d-grid gap-2 mb-3">
                                        <button type="submit" class="btn btn-warning text-white fw-bold">Entrar</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/usuario-form.js"></script> 
</body>
</html>