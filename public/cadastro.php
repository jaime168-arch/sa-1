<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
   
         <div class="main-container">
        <nav class="navbar navbar-orange navbar-ismaga py-3">
            <div class="container justify-content-center">
                <a class="navbar-brand text-white fw-bold m-0" href="../index.php">+ Já.Ismaga</a>
            </div>
        </nav>
    
               <div class="cadastro-wrapper"> <br><br>
            <div class="container">
                <div class="row justify-content-center w-100 m-0">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-ismaga">Criar Conta</h2>
                            <p class="text-muted">Cadastre-se na <strong>Já Ismaga</strong></p>
                        </div>

                        <form id="formCadastro">
                            <div class="mb-3">
                                <label for="nome" class="form-label fw-semibold">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" placeholder="Seu nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">E-mail</label>
                                <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                    <input type="tel" class="form-control" id="telefone" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="senha" class="form-label fw-semibold">Senha</label>
                                    <input type="password" class="form-control" id="senha" placeholder="********" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="senhaConfirm" class="form-label fw-semibold">Confirmar</label>
                                    <input type="password" class="form-control" id="senhaConfirm" placeholder="********" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-ismaga btn-lg shadow-sm">Cadastrar Agora</button> <a href= "home.php" ></a>
                            </div>

                            <div class="text-center mt-4">
                                <span class="text-muted">Já utiliza o serviço?</span> 
                                <a href="login.php" class="text-decoration-none fw-bold" style="color: var(--laranja-ismaga);">Fazer Login</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>