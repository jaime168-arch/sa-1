<?php
$tituloPagina = "Já Ismaga - Cadastro de Rota";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

    <!-- Navbar do Sistema -->
    <nav class="navbar navbar-expand-lg navbar-orange bg-orange mb-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../index.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link active" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white p-3">
                        <h4 class="mb-0 fw-bold">Cadastro / Edição de Rota Ferroviária</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <form id="rotaForm" action="rota-salvar.php" method="POST">
                            
                            <!-- Campo oculto para ID (necessário no UPDATE/Edição) -->
                            <input type="hidden" name="id" value="">

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="nomeRota" class="form-label fw-semibold">Nome / Identificação da Rota <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomeRota" name="nome_rota" required placeholder="Ex: Linha 1 - Norte/Sul">
                                </div>
                                <div class="col-md-4">
                                    <label for="codigoRota" class="form-label fw-semibold">Código da Linha <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigoRota" name="codigo_rota" required placeholder="Ex: ROT-01">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="estacaoOrigem" class="form-label fw-semibold">Estação de Origem <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="estacaoOrigem" name="estacao_origem" required placeholder="Ex: Estação Central">
                                </div>
                                <div class="col-md-6">
                                    <label for="estacaoDestino" class="form-label fw-semibold">Estação de Destino <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="estacaoDestino" name="estacao_destino" required placeholder="Ex: Terminal Industrial">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="distanciaKm" class="form-label fw-semibold">Distância Total (em km/m) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="distanciaKm" name="distancia" required placeholder="Ex: 12.50">
                                </div>
                                <div class="col-md-6">
                                    <label for="statusRota" class="form-label fw-semibold">Status Operacional <span class="text-danger">*</span></label>
                                    <select class="form-select" id="statusRota" name="status_rota" required>
                                        <option value="ativa" selected>Ativa / Liberada</option>
                                        <option value="manutencao">Em Manutenção</option>
                                        <option value="bloqueada">Bloqueada / Desativada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="observacoes" class="form-label fw-semibold">Observações do Trecho</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Insira informações sobre desvios, velocidade máxima permitida ou trechos críticos..."></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="rotas.php" class="btn btn-secondary px-4 fw-bold">Cancelar</a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold">Salvar Rota</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>