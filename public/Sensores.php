<?php
session_start();

// Proteção da página: exige login
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

// Conexão com o Banco de Dados
require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

// Ajusta/Cria a estrutura da tabela 'sensores' automaticamente no MySQL
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS sensores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        codigo_sensor VARCHAR(50) NOT NULL,
        tipo VARCHAR(100) NOT NULL,
        localizacao VARCHAR(100) NOT NULL,
        status_leitura VARCHAR(50) NOT NULL DEFAULT 'Ativo',
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $columns = $pdo->query("SHOW COLUMNS FROM sensores")->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('codigo_sensor', $columns)) {
        $pdo->exec("ALTER TABLE sensores ADD COLUMN codigo_sensor VARCHAR(50) NOT NULL AFTER id;");
    }
    if (!in_array('tipo', $columns)) {
        $pdo->exec("ALTER TABLE sensores ADD COLUMN tipo VARCHAR(100) NOT NULL AFTER codigo_sensor;");
    }
    if (!in_array('localizacao', $columns)) {
        $pdo->exec("ALTER TABLE sensores ADD COLUMN localizacao VARCHAR(100) NOT NULL AFTER tipo;");
    }
    if (!in_array('status_leitura', $columns)) {
        $pdo->exec("ALTER TABLE sensores ADD COLUMN status_leitura VARCHAR(50) NOT NULL DEFAULT 'Ativo' AFTER localizacao;");
    }
} catch (PDOException $e) {
    error_log("Erro ao ajustar tabela sensores: " . $e->getMessage());
}

// Busca a lista dinâmica de sensores cadastrados
$listaSensores = [];
try {
    $stmt = $pdo->query("SELECT id, codigo_sensor, tipo, localizacao, status_leitura FROM sensores ORDER BY id DESC");
    $listaSensores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar sensores: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro MySQL: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Monitorização de Sensores</title>
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
        
        <!-- Mensagens de Alerta (Sucesso/Erro) -->
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-cpu-fill me-2"></i>Monitorização de Sensores</h2>
            <a href="sensor-form.php" class="btn btn-warning text-white fw-bold shadow-sm" style="background-color: #ff6600 !important; border: none;">
                <i class="bi bi-plus-lg me-1"></i> Registar Sensor
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <p class="text-muted">Sensores IoT de telemetria e vias ferroviárias:</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Sensor</th>
                                <th>Tipo</th>
                                <th>Localização / Trem</th>
                                <th>Última Leitura</th>
                                <th style="width: 120px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaSensores)): ?>
                                <?php foreach ($listaSensores as $s): ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?= htmlspecialchars($s['codigo_sensor']); ?></td>
                                        <td><?= htmlspecialchars($s['tipo']); ?></td>
                                        <td><?= htmlspecialchars($s['localizacao']); ?></td>
                                        <td>
                                            <?php 
                                                $status = strtolower($s['status_leitura']);
                                                $badgeClass = 'bg-success';
                                                if (str_contains($status, 'inativo') || str_contains($status, 'erro')) {
                                                    $badgeClass = 'bg-danger';
                                                } elseif (str_contains($status, 'manuten') || str_contains($status, 'alerta')) {
                                                    $badgeClass = 'bg-warning text-dark';
                                                }
                                            ?>
                                            <span class="badge <?= $badgeClass; ?>"><?= htmlspecialchars($s['status_leitura']); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="sensor-form.php?id=<?= $s['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="sensor-deletar.php?id=<?= $s['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja remover este sensor?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Nenhum sensor registado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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