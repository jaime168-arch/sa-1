<?php
session_start();

// Proteção da página: verifica se o utilizador está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'];
$paginaAtual = basename($_SERVER['PHP_SELF']);
$pageTitle   = "Já Ismaga - Cadastro de Sensor";

// Conexão com o banco de dados (se disponível)
require_once __DIR__ . '/../config/conexao.php';

// Mocks temporários caso a conexão ainda não devolva os dados
$trens = [
    ['id' => 1, 'nome' => 'Trem 101 - Linha Verde'],
    ['id' => 2, 'nome' => 'Trem 202 - Linha Azul']
];

$rotas = [
    ['id' => 1, 'nome' => 'ROT-01 - Linha 1 (Norte/Sul)'],
    ['id' => 2, 'nome' => 'ROT-02 - Linha 2 (Leste/Oeste)']
];

// Dados padrões do sensor
$sensor = [
    'id'            => '',
    'codigo_sensor' => '',
    'tipo_sensor'   => '',
    'trem_id'       => '',
    'rota_id'       => '',
    'pino_esp32'    => '',
    'status_sensor' => 'ativo',
    'descricao'     => ''
];

// Se receber ID via GET, busca os dados para Edição
$id = $_GET['id'] ?? null;
if ($id && isset($pdo)) {
    $stmt = $pdo->prepare("SELECT * FROM sensores WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $sensorCarregado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($sensorCarregado) {
        $sensor = $sensorCarregado;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar Padronizada -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 me-4 text-dark" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'trens.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php' || $paginaAtual == 'sensor-form.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-cpu-fill fs-2 text-warning me-3" style="color: #ff6600 !important;"></i>
                            <h3 class="fw-bold text-dark m-0">
                                <?= !empty($sensor['id']) ? 'Editar Sensor IoT' : 'Cadastrar Sensor IoT'; ?>
                            </h3>
                        </div>

                        <form id="sensorForm" action="sensor-salvar.php" method="POST">
                            
                            <input type="hidden" name="id" value="<?= htmlspecialchars($sensor['id']); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="codigoSensor" class="form-label fw-semibold">Código do Sensor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="codigoSensor" name="codigo_sensor" value="<?= htmlspecialchars($sensor['codigo_sensor']); ?>" required placeholder="Ex: SEN-RFID-01">
                                </div>
                                <div class="col-md-6">
                                    <label for="tipoSensor" class="form-label fw-semibold">Tipo do Sensor <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="tipoSensor" name="tipo_sensor" required>
                                        <option value="" disabled <?= empty($sensor['tipo_sensor']) ? 'selected' : ''; ?>>Selecione o tipo...</option>
                                        <option value="rfid" <?= ($sensor['tipo_sensor'] == 'rfid') ? 'selected' : ''; ?>>RFID / Identificação</option>
                                        <option value="ultrassonico" <?= ($sensor['tipo_sensor'] == 'ultrassonico') ? 'selected' : ''; ?>>Ultrassônico / Distância</option>
                                        <option value="presenca" <?= ($sensor['tipo_sensor'] == 'presenca') ? 'selected' : ''; ?>>Infravermelho / Presença</option>
                                        <option value="velocidade" <?= ($sensor['tipo_sensor'] == 'velocidade') ? 'selected' : ''; ?>>Encoder / Velocidade</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="tremId" class="form-label fw-semibold">Vínculo com Trem</label>
                                    <select class="form-select rounded-3" id="tremId" name="trem_id">
                                        <option value="">Nenhum (Instalado na via)</option>
                                        <?php foreach ($trens as $trem): ?>
                                            <option value="<?= $trem['id']; ?>" <?= ($sensor['trem_id'] == $trem['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($trem['nome']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="rotaId" class="form-label fw-semibold">Vínculo com Rota / Trecho</label>
                                    <select class="form-select rounded-3" id="rotaId" name="rota_id">
                                        <option value="">Nenhum (Em embarcação móvel)</option>
                                        <?php foreach ($rotas as $rota): ?>
                                            <option value="<?= $rota['id']; ?>" <?= ($sensor['rota_id'] == $rota['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($rota['nome']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="pinoEsp32" class="form-label fw-semibold">Pino / Porta no ESP32 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="pinoEsp32" name="pino_esp32" value="<?= htmlspecialchars($sensor['pino_esp32']); ?>" required placeholder="Ex: GPIO21 ou D2">
                                </div>
                                <div class="col-md-6">
                                    <label for="statusSensor" class="form-label fw-semibold">Status Operacional <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="statusSensor" name="status_sensor" required>
                                        <option value="ativo" <?= ($sensor['status_sensor'] == 'ativo') ? 'selected' : ''; ?>>Ativo / Operacional</option>
                                        <option value="inativo" <?= ($sensor['status_sensor'] == 'inativo') ? 'selected' : ''; ?>>Inativo / Desligado</option>
                                        <option value="defeito" <?= ($sensor['status_sensor'] == 'defeito') ? 'selected' : ''; ?>>Com Defeito</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="descricao" class="form-label fw-semibold">Localização Exata / Descrição</label>
                                <textarea class="form-control rounded-3" id="descricao" name="descricao" rows="3" placeholder="Ex: Instalado no Pátio 1, a 50 metros do semáforo de entrada..."><?= htmlspecialchars($sensor['descricao']); ?></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="sensores.php" class="btn btn-secondary px-4 fw-bold rounded-3">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold rounded-3 shadow-sm" style="background-color: #ff6600 !important; border: none;">
                                    Salvar Sensor
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Rodapé Padronizado -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>