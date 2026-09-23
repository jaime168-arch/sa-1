<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Precisa de fazer login para aceder a esta página.";
    header("Location: login.php");
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'];
$paginaAtual = basename($_SERVER['PHP_SELF']);
$pageTitle   = "Já Ismaga - Cadastro de Trem";

require_once __DIR__ . '/../config/conexao.php';

$rotas = [
    ['id' => 1, 'nome' => 'ROT-01 - Linha 1 (Norte/Sul)'],
    ['id' => 2, 'nome' => 'ROT-02 - Linha 2 (Leste/Oeste)']
];

$trem = [
    'id'             => '',
    'codigo_trem'    => '',
    'modelo'         => '',
    'capacidade'     => '',
    'velocidade_max' => '',
    'rota_id'        => '',
    'status_trem'    => 'operacional',
    'observacoes'    => ''
];

$id = $_GET['id'] ?? null;
if ($id && isset($pdo)) {
    $stmt = $pdo->prepare("SELECT * FROM trens WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $tremCarregado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($tremCarregado) {
        $trem = $tremCarregado;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

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
                        <a class="nav-link text-dark <?= ($paginaAtual == 'trens.php' || $paginaAtual == 'trem-form.php') ? 'fw-bold active' : ''; ?>" href="trens.php">Trens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'rotas.php') ? 'fw-bold active' : ''; ?>" href="rotas.php">Rotas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?= ($paginaAtual == 'sensores.php') ? 'fw-bold active' : ''; ?>" href="sensores.php">Sensores</a>
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

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-train-front-fill fs-2 text-warning me-3" style="color: #ff6600 !important;"></i>
                            <h3 class="fw-bold text-dark m-0">
                                <?= !empty($trem['id']) ? 'Editar Trem' : 'Cadastrar Novo Trem'; ?>
                            </h3>
                        </div>

                        <form id="tremForm" action="trem-salvar.php" method="POST">
                            
                            <input type="hidden" name="id" value="<?= htmlspecialchars($trem['id']); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="codigoTrem" class="form-label fw-semibold">Código do Trem <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="codigoTrem" name="codigo_trem" value="<?= htmlspecialchars($trem['codigo_trem']); ?>" required placeholder="Ex: TRN-101">
                                </div>
                                <div class="col-md-6">
                                    <label for="modelo" class="form-label fw-semibold">Modelo / Descrição <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rounded-3" id="modelo" name="modelo" value="<?= htmlspecialchars($trem['modelo']); ?>" required placeholder="Ex: Locomotiva Elétrica Class A">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="capacidade" class="form-label fw-semibold">Capacidade (Passageiros/Carga) <span class="text-danger">*</span></label>
                                    <input type="number" min="1" class="form-control rounded-3" id="capacidade" name="capacidade" value="<?= htmlspecialchars($trem['capacidade']); ?>" required placeholder="Ex: 120">
                                </div>
                                <div class="col-md-6">
                                    <label for="velocidadeMax" class="form-label fw-semibold">Velocidade Máxima (km/h) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.1" min="0" class="form-control rounded-3" id="velocidadeMax" name="velocidade_max" value="<?= htmlspecialchars($trem['velocidade_max']); ?>" required placeholder="Ex: 80.0">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="rotaId" class="form-label fw-semibold">Rota Atribuída</label>
                                    <select class="form-select rounded-3" id="rotaId" name="rota_id">
                                        <option value="">Nenhuma (Em pátio / Sem rota definida)</option>
                                        <?php foreach ($rotas as $rota): ?>
                                            <option value="<?= $rota['id']; ?>" <?= ($trem['rota_id'] == $rota['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($rota['nome']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="statusTrem" class="form-label fw-semibold">Status Operacional <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3" id="statusTrem" name="status_trem" required>
                                        <option value="operacional" <?= ($trem['status_trem'] == 'operacional') ? 'selected' : ''; ?>>Operacional / Em Serviço</option>
                                        <option value="manutencao" <?= ($trem['status_trem'] == 'manutencao') ? 'selected' : ''; ?>>Em Manutenção</option>
                                        <option value="inativo" <?= ($trem['status_trem'] == 'inativo') ? 'selected' : ''; ?>>Inativo / Desativado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="observacoes" class="form-label fw-semibold">Observações do Veículo</label>
                                <textarea class="form-control rounded-3" id="observacoes" name="observacoes" rows="3" placeholder="Informações de manutenção, histórico de reparos ou detalhes técnicos..."><?= htmlspecialchars($trem['observacoes']); ?></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="trens.php" class="btn btn-secondary px-4 fw-bold rounded-3">
                                    Cancelar
                                </a>
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

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted small">
        <div class="container">&copy; <?= date('Y'); ?> Já Ismaga.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>