<?php
$tituloPagina = "Já Ismaga — Ferrorama IoT";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    
    <!-- Bootstrap CSS (Carregamento via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilo Próprio (Verifique se o arquivo está na pasta styles/style.css) -->
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>

    <div class="main-container">
        <!-- Topo / Header -->
        <nav class="navbar-ismaga p-3 bg-white shadow-sm mb-4">
            <h2 class="m-0 text-dark"><strong>+ Já</strong>.Ismaga</h2>
        </nav>
        
        <!-- Conteúdo Principal -->
        <div class="login-wrapper text-center px-3 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <!-- Imagem da Locomotiva / Trem -->
                    <div class="col-12 mb-4 topo">
                        <img src="./assets/imagem_1.webp.png" alt="Trem" class="img-fluid style-img" style="max-width: 380px; width: 100%;">
                    </div>
                    
                    <div class="col-12">
                        <h1 class="display-5 fw-normal text-dark">
                            Acompanhe seu metrô
                        </h1>
                        <h1 class="display-5 fw-bold text-ismaga mb-4">
                            em <span style="color: var(--laranja-ismaga);">tempo real</span>
                        </h1>
                        
                        <div class="mt-4">
                            <a href="./public/login.php" class="btn btn-warning btn-lg px-5 py-3 fw-bold text-white shadow-sm">
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