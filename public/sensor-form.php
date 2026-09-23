<?php
session_start();

// Proteção da página: exige login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso não autorizado.";
    header("Location: login.php");
    exit;
}

// Conexão com o Banco de Dados
require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

// Estrutura padrão para o formulário
$sensor = [
    'id'             => '',
    'codigo_sensor'  => '',
    'tipo'           => '',
    'localizacao'    => '',
    'status_leitura' => 'Ativo (Agora)',
    'trem_id'        => ''
];

// Se for edição, busca os dados do sensor existente
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM sensores WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $carregado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($carregado) {
            $sensor = $carregado;
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar sensor: " . $e->getMessage());
    }
}

// Busca a lista de trens cadastrados para resolver a FK (Foreign Key)
$trens = [];
try {
    $stmtTrens = $pdo->query("SELECT id, nome FROM trens ORDER BY nome ASC");
    $trens = $stmtTrens->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao buscar trens: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $sensor['id'] ? 'Editar Sensor' : 'Registar Sensor'; ?></title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 me-4 text-dark" href="home.php">+ Já.Ismaga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php' || $paginaAtual == 'rota-form.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php' || $paginaAtual == 'sensor-form.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Exibição de Mensagens de Erro -->
                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold text-dark mb-4">
                            <i class="bi bi-cpu text-warning me-2" style="color: #ff6600 !important;"></i>
                            <?= $sensor['id'] ? 'Editar Sensor' : 'Registar Novo Sensor'; ?>
                        </h3>

                        <form action="sensor-salvar.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($sensor['id']); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold">Código / ID do Sensor <span class="text-danger">*</span></label>
                                    <input type="text" name="codigo_sensor" class="form-control rounded-3" value="<?= htmlspecialchars($sensor['codigo_sensor']); ?>" required placeholder="Ex: SN-8821">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo de Sensor <span class="text-danger">*</span></label>
                                    <input type="text" name="tipo" class="form-control rounded-3" value="<?= htmlspecialchars($sensor['tipo']); ?>" required placeholder="Ex: Sensor de Presença / Carga">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold">Localização <span class="text-danger">*</span></label>
                                    <input type="text" name="localizacao" class="form-control rounded-3" value="<?= htmlspecialchars($sensor['localizacao']); ?>" required placeholder="Ex: Vagão TR-101">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Última Leitura / Status <span class="text-danger">*</span></label>
                                    <input type="text" name="status_leitura" class="form-control rounded-3" value="<?= htmlspecialchars($sensor['status_leitura']); ?>" required placeholder="Ex: Ativo (Agora)">
                                </div>
                            </div>

                            <!-- Seleção de Trem (Resolve a FK Constraint) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Trem Vinculado <span class="text-danger">*</span></label>
                                <select name="trem_id" class="form-select rounded-3" required>
                                    <option value="">Selecione um Trem...</option>
                                    <?php foreach ($trens as $t): ?>
                                        <option value="<?= $t['id']; ?>" <?= ($sensor['trem_id'] == $t['id']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($t['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="sensores.php" class="btn btn-secondary px-4 fw-bold rounded-3">Cancelar</a>
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

    <!-- Rodapé -->
    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>