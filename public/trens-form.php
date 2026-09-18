<?php
// Configurações e definições da página
$pageTitle = "Já Ismaga - Cadastro de Trem";

// Mock temporário para popular a seleção de rotas no formulário
// Futuramente, estes dados virão do banco de dados MySQL via PHP
$rotas = [
    ['id' => 1, 'nome' => 'ROT-01 - Linha 1 (Norte/Sul)'],
    ['id' => 2, 'nome' => 'ROT-02 - Linha 2 (Leste/Oeste)']
];
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
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link active" href="trens.php">Trens</a></li>
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
                        <h4 class="mb-0 fw-bold">Cadastro / Edição de Trem</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Form Handler -->
                        <form id="tremForm" action="trem-salvar.php" method="POST">
                            
                            <!-- Campo oculto para ID (Edição) -->
                            <input type="hidden" name="id" value="">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="codigoTrem" class="form-label fw-semibold">Código do Trem <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigoTrem" name="codigo_trem" required placeholder="Ex: TRN-101">
                                </div>
                                <div class="col-md-6">
                                    <label for="modelo" class="form-label fw-semibold">Modelo / Descrição <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" required placeholder="Ex: Locomotiva Elétrica Class A">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="capacidade" class="form-label fw-semibold">Capacidade (Passageiros/Carga) <span class="text-danger">*</span></label>
                                    <input type="number" min="1" class="form-control" id="capacidade" name="capacidade" required placeholder="Ex: 120">
                                </div>
                                <div class="col-md-6">
                                    <label for="velocidadeMax" class="form-label fw-semibold">Velocidade Máxima (km/h) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.1" min="0" class="form-control" id="velocidadeMax" name="velocidade_max" required placeholder="Ex: 80.0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="rotaId" class="form-label fw-semibold">Rota Atribuída</label>
                                    <select class="form-select" id="rotaId" name="rota_id">
                                        <option value="">Nenhuma (Em pátio / Sem rota definida)</option>
                                        <?php foreach ($rotas as $rota): ?>
                                            <option value="<?= $rota['id']; ?>"><?= htmlspecialchars($rota['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="statusTrem" class="form-label fw-semibold">Status Operacional <span class="text-danger">*</span></label>
                                    <select class="form-select" id="statusTrem" name="status_trem" required>
                                        <option value="operacional" selected>Operacional / Em Serviço</option>
                                        <option value="manutencao">Em Manutenção</option>
                                        <option value="inativo">Inativo / Desativado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="observacoes" class="form-label fw-semibold">Observações do Veículo</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Informações de manutenção, histórico de reparos ou detalhes técnicos..."></textarea>
                            </div>

                            <hr class="my-4">

                            <!-- Form Controls -->
                            <div class="d-flex justify-content-between">
                                <a href="trens.php" class="btn btn-secondary px-4 fw-bold">Cancelar</a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold">Salvar Trem</button>
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