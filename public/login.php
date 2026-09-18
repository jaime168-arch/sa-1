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
            <div class="container justify-content-center">
                <h2 class="m-0"><strong>+ Já</strong>.Ismaga</h2>
            </div>
        </nav>
            <div class="login-wrapper d-flex align-items-center flex-grow-1 py-5">
            <div class="container">
                <div class="row justify-content-center m-0">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        
                        <div class="card shadow-lg border-0 p-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <h2 class="fw-bold text-ismaga">Login</h2>
                                    <p class="text-muted small">Acesse o sistema ferroviário</p>
                                </div>

                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="exemplo@gmail.com" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Senha</label>
                                        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
                                    </div>
                                    
                                    <div class="d-grid gap-2 mb-3 mt-4">
                                      <button type="submit" class="btn btn-ismaga">Entrar</button>
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <small class="text-muted">Não tem conta?</small>
                                    <a href="cadastro.php" class="small fw-bold text-decoration-none" style="color: var(--laranja-ismaga);">Cadastre-se</a>
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
