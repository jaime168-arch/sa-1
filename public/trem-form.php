<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Acesso não autorizado. Faça login para continuar.";
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado: Apenas administradores podem cadastrar ou editar trens.";
    header("Location: trens.php");
    exit;
}

require_once __DIR__ . '/../config/conexao.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Utilizador';
$paginaAtual = basename($_SERVER['PHP_SELF']);

$trem = [
    'id'         => '',
    'nome'       => '',
    'modelo'     => '',
    'capacidade' => '',
    'status'     => 'ativo',
    'usuario_id' => ''
];

// Se for Edição, carrega os dados do trem pelo ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM trens WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $carregado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($carregado) {
            $trem = $carregado;
        } else {
            $_SESSION['mensagem_erro'] = "Trem não encontrado.";
            header("Location: trens.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar trem: " . $e->getMessage());
        $_SESSION['mensagem_erro'] = "Erro ao carregar dados do trem.";
    }
}

// Carrega a lista de utilizadores cadastrados para a seleção do Responsável
$listaUsuarios = [];
try {
    $stmtU = $pdo->query("SELECT id, nome, tipo FROM usuarios WHERE ativo = 1 ORDER BY nome ASC");
    $listaUsuarios = $stmtU->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao carregar utilizadores: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Já Ismaga - <?= $trem['id'] ? 'Editar Trem #' . $trem['id'] : 'Novo Trem'; ?></title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm sticky-top" style="background-color: #ff6600 !important;">
        <div class="container.fluid px-4">
            <a class="navbar-brand fw-bold fs-4 me-4 text-white" href="home.php">+ Já.Ismaga</a>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

              
                <div class="card border-0 shadow rounded-4" style="background-color: rgb(255, 249, 240);">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 px-md-5 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold text-dark m-0">
                            <i class="bi bi-train-front me-2" style="color: #ff6600;"></i>
                            <?= $trem['id'] ? 'Editar Trem' : 'Cadastrar Novo Trem'; ?>
                        </h3>
                        <a href="trens.php" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar à Lista
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5 pt-3">
                        <p class="text-muted small mb-4">Preencha as informações abaixo para <?= $trem['id'] ? 'atualizar os dados do' : 'cadastrar um novo'; ?> trem na frota do sistema Ferroramas.</p>

                        <form action="trem-salvar.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($trem['id']); ?>">

                            <div class="row g-3 mb-3">
                             
                                <div class="col-md-6">
                                    <label for="nome" class="form-label fw-semibold text-dark">Nome do Trem <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3"><i class="bi bi-tag"></i></span>
                                        <input type="text" id="nome" name="nome" class="form-control border-start-0 rounded-end-3" value="<?= htmlspecialchars($trem['nome']); ?>" required placeholder="Ex: Expressa Ferrorama">
                                    </div>
                                </div>

                               
                                <div class="col-md-6">
                                    <label for="modelo" class="form-label fw-semibold text-dark">Modelo <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3"><i class="bi bi-cpu"></i></span>
                                        <input type="text" id="modelo" name="modelo" class="form-control border-start-0 rounded-end-3" value="<?= htmlspecialchars($trem['modelo']); ?>" required placeholder="Ex: EF-2000">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                               
                                <div class="col-md-6">
                                    <label for="capacidade" class="form-label fw-semibold text-dark">Capacidade (Passageiros) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3"><i class="bi bi-people"></i></span>
                                        <input type="number" id="capacidade" name="capacidade" class="form-control border-start-0 rounded-end-3" value="<?= htmlspecialchars($trem['capacidade']); ?>" required min="1" placeholder="Ex: 350">
                                    </div>
                                </div>

                              
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold text-dark">Estado de Operação <span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-select rounded-3" required>
                                        <option value="ativo" <?= ($trem['status'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                                        <option value="manutencao" <?= ($trem['status'] == 'manutencao') ? 'selected' : ''; ?>>Em Manutenção</option>
                                        <option value="inativo" <?= ($trem['status'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="usuario_id" class="form-label fw-semibold text-dark">Usuário Responsável</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3"><i class="bi bi-person-badge"></i></span>
                                    <select id="usuario_id" name="usuario_id" class="form-select border-start-0 rounded-end-3">
                                        <option value="">-- Sem responsável atribuído --</option>
                                        <?php foreach ($listaUsuarios as $u): ?>
                                            <option value="<?= $u['id']; ?>" <?= ((int)$trem['usuario_id'] === (int)$u['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($u['nome']); ?> (<?= ucfirst($u['tipo']); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <small class="form-text text-muted">Selecione o funcionário ou supervisor que ficará encarregado deste trem.</small>
                            </div>

                            <hr class="my-4">

                            
                            <div class="d-flex justify-content-end gap-3 align-items-center">
                                <a href="trens.php" class="btn btn-secondary px-4 fw-bold rounded-3">Cancelar</a>
                                <button type="submit" class="btn text-white px-4 fw-bold rounded-3 shadow-sm" style="background-color: #ff6600 !important; border: none;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Salvar Trem
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