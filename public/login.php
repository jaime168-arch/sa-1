<?php
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

                                <form id="loginForm" action="usuarios.php" method="POST">
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

                                <div class="text-center mt-3">
                                    <small class="text-muted">Não tem conta?</small>
                                    <a href="usuario-form.php" class="small fw-bold text-orange text-orange">Cadastre-se</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script> 
</body>
</html>