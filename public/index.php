<?php
$pageTitle = "Já Ismaga - Início";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css?v=<?= time(); ?>">
</head>
<body class="bg-light">

    <div class="main-container">
        <nav class="navbar navbar-dark bg-dark py-3 navbar-ismaga">
            <div class="container-fluid px-4">
                <h2 class="m-0 text-white fs-3"><strong>+ Já</strong>.Ismaga</h2>
            </div>
        </nav>
        
        <div class="login-wrapper text-center px-3 my-5">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <div class="col-12 mb-4 topo">
                        <img src="../assets/imagem_1.webp.png" alt="Trem" class="img-fluid style-img" style="max-width: 400px; width: 100%;">
                    </div>
                    
                    <div class="col-12">
                        <h1 class="display-5 fw-normal text-dark">
                            Acompanhe seu metrô
                        </h1>
                        <h1 class="display-5 fw-bold text-dark mb-4">
                            em <span class="text-warning" style="color: var(--laranja-ismaga);">tempo real</span>
                        </h1>
                        
                        <div class="mt-4">
                            <a href="login.php" class="btn btn-warning btn-lg px-4 py-2 fw-bold text-dark botao">
                                Clique aqui para acessar
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>