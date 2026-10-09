<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado: Apenas administradores podem gerenciar rotas.";
    header("Location: rotas.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

$rota = [
    'id'             => '',
    'nome_rota'      => '',
    'descricao'      => '',
    'origem'         => '',
    'destino'        => '',
    'distancia_km'   => '',
    'tempo_previsto' => '',
    'trem_id'        => '',
    'status_rota'    => 'ativa'
];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM rotas WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $carregado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($carregado) {
            $rota = $carregado;
        } else {
            $_SESSION['mensagem_erro'] = "Rota não encontrada.";
            header("Location: rotas.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar rota: " . $e->getMessage());
    }
}

$listaTrens = [];
try {
    $stmtT = $pdo->query("SELECT id, nome, modelo FROM trens WHERE status = 'ativo' ORDER BY nome ASC");
    $listaTrens = $stmtT->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar trens: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_rota      = trim($_POST['nome_rota'] ?? '');
    $descricao      = trim($_POST['descricao'] ?? '');
    $origem         = trim($_POST['origem'] ?? '');
    $destino        = trim($_POST['destino'] ?? '');
    $distancia_km   = filter_input(INPUT_POST, 'distancia_km', FILTER_VALIDATE_FLOAT);
    $tempo_previsto = trim($_POST['tempo_previsto'] ?? '');
    $trem_id        = filter_input(INPUT_POST, 'trem_id', FILTER_VALIDATE_INT) ?: null;
    $status_rota    = trim($_POST['status_rota'] ?? 'ativa');

    // Validações no Backend
    if (empty($nome_rota) || empty($origem) || empty($destino) || $distancia_km === false || $distancia_km <= 0 || empty($tempo_previsto)) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios corretamente (Distância deve ser um número positivo).";
    } else {
        try {
            if ($id) {
                $sql = "UPDATE rotas SET nome_rota = :nome_rota, descricao = :descricao, origem = :origem, destino = :destino, distancia_km = :distancia_km, tempo_previsto = :tempo_previsto, trem_id = :trem_id, status_rota = :status_rota WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nome_rota'      => $nome_rota,
                    ':descricao'      => $descricao,
                    ':origem'         => $origem,
                    ':destino'        => $destino,
                    ':distancia_km'   => $distancia_km,
                    ':tempo_previsto' => $tempo_previsto,
                    ':trem_id'        => $trem_id,
                    ':status_rota'    => $status_rota,
                    ':id'             => $id
                ]);
                $_SESSION['mensagem_sucesso'] = "Rota '{$nome_rota}' atualizada com sucesso!";
            } else {
                // INSERT
                $sql = "INSERT INTO rotas (nome_rota, descricao, origem, destino, distancia_km, tempo_previsto, trem_id, status_rota) VALUES (:nome_rota, :descricao, :origem, :destino, :distancia_km, :tempo_previsto, :trem_id, :status_rota)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nome_rota'      => $nome_rota,
                    ':descricao'      => $descricao,
                    ':origem'         => $origem,
                    ':destino'        => $destino,
                    ':distancia_km'   => $distancia_km,
                    ':tempo_previsto' => $tempo_previsto,
                    ':trem_id'        => $trem_id,
                    ':status_rota'    => $status_rota
                ]);
                $_SESSION['mensagem_sucesso'] = "Rota '{$nome_rota}' cadastrada com sucesso!";
            }

            header("Location: rotas.php");
            exit;

        } catch (PDOException $e) {
            error_log("Erro ao salvar rota: " . $e->getMessage());
            $_SESSION['mensagem_erro'] = "Erro ao salvar os dados da rota no banco de dados.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $rota['id'] ? 'Editar Rota #' . $rota['id'] : 'Nova Rota'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container.fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white" href="home.php">+ Já.Ismaga</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php' || $paginaAtual == 'rota-form.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%);">
                    <span class="text-dark">Olá, <strong><?= htmlspecialchars($nomeUsuario); ?></strong></span>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-box-arrow-right me-1"></i> Sair</a>
                </div>
            </div>
        </div>
    </nav>


    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($_SESSION['mensagem_erro']); unset($_SESSION['mensagem_erro']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow rounded-4" style="background-color: rgb(255, 249, 240);">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 px-md-5 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold text-dark m-0">
                            <i class="bi bi-map me-2" style="color: #ff6600;"></i>
                            <?= $rota['id'] ? 'Editar Rota' : 'Cadastrar Nova Rota'; ?>
                        </h3>
                        <a href="rotas.php" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5 pt-3">
                        <form action="" method="POST">
                            
                            <div class="mb-3">
                                <label for="nome_rota" class="form-label fw-semibold">Nome da Rota <span class="text-danger">*</span></label>
                                <input type="text" id="nome_rota" name="nome_rota" class="form-control rounded-3" value="<?= htmlspecialchars($rota['nome_rota']); ?>" required placeholder="Ex: Linha Central Expressa">
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label fw-semibold">Descrição</label>
                                <textarea id="descricao" name="descricao" class="form-control rounded-3" rows="2" placeholder="Informações detalhadas sobre o percurso e paradas..."><?= htmlspecialchars($rota['descricao']); ?></textarea>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="origem" class="form-label fw-semibold">Estação de Origem <span class="text-danger">*</span></label>
                                    <input type="text" id="origem" name="origem" class="form-control rounded-3" value="<?= htmlspecialchars($rota['origem']); ?>" required placeholder="Ex: Estação Central">
                                </div>
                                <div class="col-md-6">
                                    <label for="destino" class="form-label fw-semibold">Estação de Destino <span class="text-danger">*</span></label>
                                    <input type="text" id="destino" name="destino" class="form-control rounded-3" value="<?= htmlspecialchars($rota['destino']); ?>" required placeholder="Ex: Terminal Norte">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="distancia_km" class="form-label fw-semibold">Distância (KM) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" id="distancia_km" name="distancia_km" class="form-control rounded-3" value="<?= htmlspecialchars($rota['distancia_km']); ?>" required min="0.1" placeholder="Ex: 45.50">
                                </div>
                                <div class="col-md-6">
                                    <label for="tempo_previsto" class="form-label fw-semibold">Tempo Previsto / Duração <span class="text-danger">*</span></label>
                                    <input type="text" id="tempo_previsto" name="tempo_previsto" class="form-control rounded-3" value="<?= htmlspecialchars($rota['tempo_previsto']); ?>" required placeholder="Ex: 01h 15m">
                                </div>
                            </div>

                            <!-- SELEÇÃO DO TREM VINCULADO (Requisito Etapa 8) -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="trem_id" class="form-label fw-semibold">Trem Vinculado</label>
                                    <select id="trem_id" name="trem_id" class="form-select rounded-3">
                                        <option value="">-- Nenhum trem vinculado --</option>
                                        <?php foreach ($listaTrens as $t): ?>
                                            <option value="<?= $t['id']; ?>" <?= ((int)$rota['trem_id'] === (int)$t['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($t['nome']); ?> (<?= htmlspecialchars($t['modelo']); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="status_rota" class="form-label fw-semibold">Estado da Rota</label>
                                    <select id="status_rota" name="status_rota" class="form-select rounded-3">
                                        <option value="ativa" <?= ($rota['status_rota'] === 'ativa') ? 'selected' : ''; ?>>Ativa</option>
                                        <option value="inativa" <?= ($rota['status_rota'] === 'inativa') ? 'selected' : ''; ?>>Inativa</option>
                                        <option value="manutencao" <?= ($rota['status_rota'] === 'manutencao') ? 'selected' : ''; ?>>Em Manutenção</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-3 align-items-center">
                                <a href="rotas.php" class="btn btn-secondary px-4 fw-bold rounded-3">Cancelar</a>
                                <button type="submit" class="btn text-white px-4 fw-bold rounded-3 shadow-sm" style="background-color: #ff6600 !important; border: none;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Salvar Rota
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga. Todos os direitos reservados.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>