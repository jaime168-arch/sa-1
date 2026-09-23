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

// Ajusta/Cria a estrutura da tabela 'rotas' automaticamente no MySQL
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS rotas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        origem VARCHAR(100) NOT NULL,
        destino VARCHAR(100) NOT NULL,
        distancia DECIMAL(8,2) NOT NULL,
        tempo_estimado VARCHAR(50) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $columns = $pdo->query("SHOW COLUMNS FROM rotas")->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('origem', $columns)) {
        $pdo->exec("ALTER TABLE rotas ADD COLUMN origem VARCHAR(100) NOT NULL AFTER id;");
    }
    if (!in_array('destino', $columns)) {
        $pdo->exec("ALTER TABLE rotas ADD COLUMN destino VARCHAR(100) NOT NULL AFTER origem;");
    }
    if (!in_array('distancia', $columns)) {
        $pdo->exec("ALTER TABLE rotas ADD COLUMN distancia DECIMAL(8,2) NOT NULL AFTER destino;");
    }
    if (!in_array('tempo_estimado', $columns)) {
        $pdo->exec("ALTER TABLE rotas ADD COLUMN tempo_estimado VARCHAR(50) NOT NULL AFTER distancia;");
    }
} catch (PDOException $e) {
    error_log("Erro ao ajustar tabela rotas: " . $e->getMessage());
}

// Busca a lista dinâmica de rotas cadastradas
$listaRotas = [];
try {
    $stmt = $pdo->query("SELECT id, origem, destino, distancia, tempo_estimado FROM rotas ORDER BY id DESC");
    $listaRotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar rotas: " . $e->getMessage());
    $_SESSION['mensagem_erro'] = "Erro MySQL: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - Gestão de Rotas</title>
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php' || $paginaAtual == 'rota-form.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal: Rotas -->
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
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-map-fill me-2"></i>Mapeamento de Rotas</h2>
            <a href="rota-form.php" class="btn btn-warning text-white fw-bold shadow-sm" style="background-color: #ff6600 !important; border: none;">
                <i class="bi bi-plus-lg me-1"></i> Nova Rota
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <p class="text-muted">Trajetos e itinerários ativos:</p>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Origem</th>
                                <th>Destino</th>
                                <th>Distância (km)</th>
                                <th>Tempo Estimado</th>
                                <th style="width: 120px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($listaRotas)): ?>
                                <?php foreach ($listaRotas as $r): ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?= htmlspecialchars($r['origem']); ?></td>
                                        <td><?= htmlspecialchars($r['destino']); ?></td>
                                        <td><?= number_format((float)$r['distancia'], 1, ',', '.'); ?> km</td>
                                        <td><?= htmlspecialchars($r['tempo_estimado']); ?></td>
                                        <td class="text-center">
                                            <a href="rota-form.php?id=<?= $r['id']; ?>" class="btn btn-sm btn-outline-secondary me-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="rota-deletar.php?id=<?= $r['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja remover esta rota?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Nenhuma rota cadastrada.</td>
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