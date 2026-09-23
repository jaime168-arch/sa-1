<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso não autorizado.";
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

$trem = [
    'id'         => '',
    'codigo'     => '',
    'modelo'     => '',
    'capacidade' => '',
    'status'     => 'Em Operação'
];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM trens WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $carregado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($carregado) {
            $trem = $carregado;
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar trem: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $trem['id'] ? 'Editar Trem' : 'Novo Trem'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 me-4 text-dark" href="home.php">+ Já.Ismaga</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto fw-semibold">
                     <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'home.php') ? 'fw-bold active' : ''; ?>" href="home.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'usuarios.php' || $paginaAtual == 'usuario-form.php') ? 'fw-bold active' : ''; ?>" href="usuarios.php">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a></li>
                    <li class="nav-item"><a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold text-dark mb-4">
                            <i class="bi bi-train-front text-warning me-2" style="color: #ff6600 !important;"></i>
                            <?= $trem['id'] ? 'Editar Trem' : 'Cadastrar Novo Trem'; ?>
                        </h3>

                        <form action="trem-salvar.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($trem['id']); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold">Código do Trem <span class="text-danger">*</span></label>
                                    <input type="text" name="codigo" class="form-control rounded-3" value="<?= htmlspecialchars($trem['codigo']); ?>" required placeholder="Ex: TR-101">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Modelo <span class="text-danger">*</span></label>
                                    <input type="text" name="modelo" class="form-control rounded-3" value="<?= htmlspecialchars($trem['modelo']); ?>" required placeholder="Ex: Locomotiva Express 2000">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold">Capacidade (Passageiros) <span class="text-danger">*</span></label>
                                    <input type="number" name="capacidade" class="form-control rounded-3" value="<?= htmlspecialchars($trem['capacidade']); ?>" required placeholder="Ex: 450">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status de Operação <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select rounded-3" required>
                                        <option value="Em Operação" <?= ($trem['status'] == 'Em Operação') ? 'selected' : ''; ?>>Em Operação</option>
                                        <option value="Em Manutenção" <?= ($trem['status'] == 'Em Manutenção') ? 'selected' : ''; ?>>Em Manutenção</option>
                                        <option value="Inativo" <?= ($trem['status'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="trens.php" class="btn btn-secondary px-4 fw-bold rounded-3">Cancelar</a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold rounded-3 shadow-sm" style="background-color: #ff6600 !important; border: none;">
                                    Salvar Trem
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>