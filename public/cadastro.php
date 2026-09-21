<?php
session_start();
$pageTitle = "Já Ismaga - Criar Conta";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm py-3">
        <div class="container justify-content-center">
            <a class="navbar-brand text-white fw-bold fs-4 m-0" href="../index.php">
                + Já.Ismaga
            </a>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        
                        <!-- Título e Subtítulo -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-dark mb-1">Criar Conta</h2>
                            <p class="text-muted small">Registe-se na plataforma de gestão ferroviária</p>
                        </div>

                        <!-- Feedback de Notificações da Sessão -->
                        <?php if (isset($_SESSION['mensagem_erro'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 small mb-3" role="alert">
                                <?= htmlspecialchars($_SESSION['mensagem_erro']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                            <?php unset($_SESSION['mensagem_erro']); ?>
                        <?php endif; ?>

                        <!-- Formulário de Cadastro -->
                        <form id="formCadastro" action="usuario-salvar.php" method="POST" novalidate>
                            
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="nome" name="nome" placeholder="Seu Nome Completo" autocomplete="name" required>
                                <label for="nome" class="text-secondary">Nome Completo</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="nome@exemplo.com" autocomplete="email" required>
                                <label for="email" class="text-secondary">Endereço de E-mail</label>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control rounded-3" id="senha" name="senha" placeholder="Palavra-passe" required>
                                        <label for="senha" class="text-secondary">Palavra-passe</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control rounded-3" id="confirmar_senha" name="confirmar_senha" placeholder="Confirmar" required>
                                        <label for="confirmar_senha" class="text-secondary">Confirmar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 my-3">
                                <button type="submit" class="btn btn-warning text-white fw-bold btn-lg rounded-3 shadow-sm py-2">
                                    Cadastrar Agora
                                </button>
                            </div>

                        </form>

                        <hr class="my-4 text-muted">

                        <!-- Redirecionamento para Login -->
                        <div class="text-center">
                            <span class="text-muted small">Já utiliza o serviço?</span>
                            <br>
                            <a href="login.php" class="fw-bold text-warning text-decoration-none small fs-6">
                                Fazer Login &rarr;
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/cadastro.js"></script>
</body>
</html>