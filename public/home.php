<?php
session_start();

// Se não houver sessão ativa, redireciona para o login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Painel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar do Painel -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">+ Já.Ismaga</a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>

    <!-- Conteúdo do Painel -->
    <main class="container my-5">
        <div class="p-5 mb-4 bg-white rounded-4 shadow-sm">
            <h1 class="display-5 fw-bold text-dark">Bem-vindo ao Sistema!</h1>
            <p class="col-md-8 fs-4 text-muted">Sessão iniciada com sucesso. A partir daqui pode gerir os módulos da plataforma.</p>
        </div>
    </main>

</body>
</html>