<<<<<<< HEAD
<?php
// Configurações e definições da página
$pageTitle = "Já Ismaga - Login";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <div class="main-container">
        <!-- Primary Navigation -->
        <nav class="navbar navbar-dark bg-dark navbar-ismaga py-3">
=======
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <div class="main-container d-flex flex-column min-vh-100">
        
        <!-- Navbar Superior -->
        <nav class="navbar navbar-dark navbar-ismaga py-3">
>>>>>>> a2fa8778a542cbaa4b5288af4385ef5df839cab4
            <div class="container justify-content-center">
                <a class="navbar-brand text-white fw-bold m-0" href="../index.php">+ Já.Ismaga</a>
            </div>
        </nav>
<<<<<<< HEAD
    
        <!-- Login Form Wrapper -->
        <div class="login-wrapper my-5">
=======
            <div class="login-wrapper d-flex align-items-center flex-grow-1 py-5">
>>>>>>> a2fa8778a542cbaa4b5288af4385ef5df839cab4
            <div class="container">
                <div class="row justify-content-center m-0">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        
                        <div class="card shadow-lg border-0 p-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold text-dark">Login</h2>
                                    <p class="text-muted small">Acesse o sistema ferroviário</p>
                                </div>

                                <!-- Form enviado via POST para processar ou redirecionar para home -->
                                <form id="loginForm" action="usuarios.php" method="POST">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@gmail.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Senha</label>
                                        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite sua senha" required>
                                    </div>
                                    
<<<<<<< HEAD
                                    <div class="d-grid gap-2 mb-3">
                                        <button type="submit" class="btn btn-warning text-white fw-bold">Entrar</button>
=======
                                    <div class="d-grid gap-2 mb-3 mt-4">
                                      <button type="submit" class="btn btn-ismaga">Entrar</button>
>>>>>>> a2fa8778a542cbaa4b5288af4385ef5df839cab4
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <small class="text-muted">Não tem conta?</small>
                                    <a href="usuario-form.php" class="small fw-bold text-decoration-none text-warning">Cadastre-se</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script> 
</body>
</html>
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script> 
</body>
</html>
>>>>>>> a2fa8778a542cbaa4b5288af4385ef5df839cab4
