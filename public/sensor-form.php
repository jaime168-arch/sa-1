<?php
// Configurações e definições da página
$pageTitle = "Já Ismaga - Cadastro de Sensor";

// Mock temporário para popular a seleção de trens e rotas no formulário
// Futuramente, esses dados virão do banco de dados via MySQLi
$trens = [
    ['id' => 1, 'nome' => 'Trem 101 - Linha Verde'],
    ['id' => 2, 'nome' => 'Trem 202 - Linha Azul']
];

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
                    <li class="nav-item"><a class="nav-link" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="sensores.php">Sensores</a></li>
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
                        <h4 class="mb-0 fw-bold">Cadastro / Edição de Sensor IoT</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Form Handler -->
                        <form id="sensorForm" action="sensor-salvar.php" method="POST">
                            
                            <!-- Campo oculto para ID (Edição) -->
                            <input type="hidden" name="id" value="">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="codigoSensor" class="form-label fw-semibold">Código do Sensor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigoSensor" name="codigo_sensor" required placeholder="Ex: SEN-RFID-01">
                                </div>
                                <div class="col-md-6">
                                    <label for="tipoSensor" class="form-label fw-semibold">Tipo do Sensor <span class="text-danger">*</span></label>
                                    <select class="form-select" id="tipoSensor" name="tipo_sensor" required>
                                        <option value="" selected disabled>Selecione o tipo...</option>
                                        <option value="rfid">RFID / Identificação</option>
                                        <option value="ultrassonico">Ultrassônico / Distância</option>
                                        <option value="presenca">Infravermelho / Presença</option>
                                        <option value="velocidade">Encoder / Velocidade</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tremId" class="form-label fw-semibold">Vínculo com Trem</label>
                                    <select class="form-select" id="tremId" name="trem_id">
                                        <option value="">Nenhum (Instalado na via)</option>
                                        <?php foreach ($trens as $trem): ?>
                                            <option value="<?= $trem['id']; ?>"><?= htmlspecialchars($trem['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="rotaId" class="form-label fw-semibold">Vínculo com Rota / Trecho</label>
                                    <select class="form-select" id="rotaId" name="rota_id">
                                        <option value="">Nenhum (Em embarcação móvel)</option>
                                        <?php foreach ($rotas as $rota): ?>
                                            <option value="<?= $rota['id']; ?>"><?= htmlspecialchars($rota['nome']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pinoEsp32" class="form-label fw-semibold">Pino / Porta no ESP32 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pinoEsp32" name="pino_esp32" required placeholder="Ex: GPIO21 ou D2">
                                </div>
                                <div class="col-md-6">
                                    <label for="statusSensor" class="form-label fw-semibold">Status Operacional <span class="text-danger">*</span></label>
                                    <select class="form-select" id="statusSensor" name="status_sensor" required>
                                        <option value="ativo" selected>Ativo / Operacional</option>
                                        <option value="inativo">Inativo / Desligado</option>
                                        <option value="defeito">Com Defeito</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label fw-semibold">Localização Exata / Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Ex: Instalado no Pátio 1, a 50 metros do semáforo de entrada..."></textarea>
                            </div>

                            <hr class="my-4">

                            <!-- Form Controls -->
                            <div class="d-flex justify-content-between">
                                <a href="sensores.php" class="btn btn-secondary px-4 fw-bold">Cancelar</a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold">Salvar Sensor</button>
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