<?php
$pageTitle = "Já Ismaga - Início";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilo customizado do projeto -->
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="bg-light">

    <div class="main-container">
        <!-- Navegação -->
        <nav class="navbar navbar-dark bg-dark py-3 navbar-ismaga">
            <div class="container-fluid px-4">
                <h2 class="m-0 text-white fs-3"><strong>+ Já</strong>.Ismaga</h2>
            </div>
        </nav>
        
        <!-- Conteúdo Principal -->
        <div class="login-wrapper text-center px-3 my-5">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <!-- Imagem principal com caminho corrigido -->
                    <div class="col-12 mb-4 topo">
                        <img src="assets/imagem_1.webp.png" alt="Trem" class="img-fluid style-img" style="max-width: 400px; width: 100%;">
                    </div>
                    
                    <!-- Textos da landing page -->
                    <div class="col-12">
                        <h1 class="display-5 fw-normal text-dark">
                            Acompanhe seu metrô
                        </h1>
                        <h1 class="display-5 fw-bold text-dark mb-4">
                            em <span class="text-warning">tempo real</span>
                        </h1>
                        
                        <!-- Botão com fallback de classe Bootstrap para garantir o visual -->
                        <div class="mt-4">
                            <a href="public/login.php" class="btn btn-warning btn-lg px-4 py-2 fw-bold text-dark botao">
                                Clique aqui para acessar
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>