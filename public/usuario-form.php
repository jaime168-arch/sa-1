<?php
// Configurações e definições da página
$pageTitle = "Já Ismaga - Cadastro de Utilizador";
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

    <!-- Primary Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="primaryNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white p-3">
                        <h4 class="mb-0 fw-bold">Cadastro / Edição de Utilizador</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Form Handler -->
                        <form id="usuarioForm" action="usuario-salvar.php" method="POST">
                            
                            <!-- Campo oculto para ID (Edição) -->
                            <input type="hidden" name="id" value="">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nome" name="nome" required placeholder="Ex: João Silva">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="Ex: joao@ismaga.com">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="senha" class="form-label fw-semibold">Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a senha">
                                </div>
                                <div class="col-md-6">
                                    <label for="perfil" class="form-label fw-semibold">Perfil de Acesso <span class="text-danger">*</span></label>
                                    <select class="form-select" id="perfil" name="perfil" required>
                                        <option value="" selected disabled>Selecione o perfil...</option>
                                        <option value="admin">Administrador</option>
                                        <option value="operador">Operador de Campo</option>
                                        <option value="visualizador">Visualizador / Passageiro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="statusUsuario" class="form-label fw-semibold">Status do Cadastro <span class="text-danger">*</span></label>
                                    <select class="form-select" id="statusUsuario" name="status_usuario" required>
                                        <option value="ativo" selected>Ativo</option>
                                        <option value="inativo">Inativo</option>
                                        <option value="bloqueado">Bloqueado</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Form Controls -->
                            <div class="d-flex justify-content-between">
                                <a href="usuarios.php" class="btn btn-secondary px-4 fw-bold">Cancelar</a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold">Salvar Utilizador</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>