<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$pageTitle = "Já Ismaga - Criar Conta";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome            = trim($_POST['nome'] ?? '');
    $email           = strtolower(trim($_POST['email'] ?? ''));
    $senha           = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // 1. Validações de campos obrigatórios
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios.";
        header("Location: cadastro.php");
        exit;
    }

    if ($senha !== $confirmar_senha) {
        $_SESSION['mensagem_erro'] = "As senhas não coincidem.";
        header("Location: cadastro.php");
        exit;
    }

    try {
        // 2. Verifica se o e-mail já existe no phpMyAdmin
        $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email LIMIT 1");
        $stmtCheck->execute([':email' => $email]);

        if ($stmtCheck->fetch()) {
            $_SESSION['mensagem_erro'] = "O e-mail '$email' já está cadastrado na base de dados.";
            header("Location: cadastro.php");
            exit;
        }

        // 3. Criptografa a senha e salva no banco de dados
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Define 'operador', ativo = 1 e trem_id = NULL explicitamente
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, ativo, trem_id) VALUES (:nome, :email, :senha, 'operador', 1, NULL)");
        $executou = $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email,
            ':senha' => $senhaHash
        ]);

        if ($executou) {
            $_SESSION['mensagem_sucesso'] = "Conta criada com sucesso! Faça o seu login.";
            header("Location: login.php"); // Redireciona para a tela de login
            exit;
        }

    } catch (PDOException $e) {
        // Se o MySQL rejeitar por qualquer erro estrutural, exibe na tela
        $_SESSION['mensagem_erro'] = "Erro de MySQL no Banco de Dados: " . $e->getMessage();
        header("Location: cadastro.php");
        exit;
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
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-orange bg-orange shadow-sm py-3">
        <div class="container justify-content-center">
            <a class="navbar-brand text-white fw-bold fs-4 m-0" href="../index.php">
                + Já.Ismaga
            </a>
        </div>
    </nav>

    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-dark mb-1">Criar Conta</h2>
                            <p class="text-muted small">Registe-se na plataforma de gestão ferroviária</p>
                        </div>

                        <?php if (isset($_SESSION['mensagem_erro'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 small mb-3" role="alert">
                                <?= htmlspecialchars($_SESSION['mensagem_erro']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                            <?php unset($_SESSION['mensagem_erro']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                            <div class="alert alert-success alert-dismissible fade show rounded-3 small mb-3" role="alert">
                                <?= htmlspecialchars($_SESSION['mensagem_sucesso']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                            <?php unset($_SESSION['mensagem_sucesso']); ?>
                        <?php endif; ?>

                        <!-- ALTERADO O action PARA "cadastro.php" PARA PROCESSAR O PHP DO TOPO -->
                        <form id="formCadastro" action="cadastro.php" method="POST" novalidate>
                            
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="nome" name="nome" placeholder="Seu Nome Completo" autocomplete="name" required>
                                <label for="nome" class="text-secondary">Nome Completo</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="nome@exemplo.com" autocomplete="email" required>
                                <label for="email" class="text-secondary">Endereço de E-mail</label>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control rounded-3" id="senha" name="senha" placeholder="Palavra-passe" required>
                                        <label for="senha" class="text-secondary">Palavra-passe</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="password" class="form-control rounded-3" id="confirmar_senha" name="confirmar_senha" placeholder="Confirmar" required>
                                        <label for="confirmar_senha" class="text-secondary">Confirmar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 my-3">
                                <button type="submit" class="btn btn-primary text-white fw-bold btn-lg rounded-3 shadow-sm py-2">
                                    Cadastrar Agora
                                </button>
                            </div>

                        </form>

                        <hr class="my-4 text-muted">

                        <div class="text-center">
                            <span class="text-muted small">Já utiliza o serviço?</span>
                            <br>
                            <a href="login.php" class="fw-bold text-orange text-decoration-none small fs-6">
                                Fazer Login &rarr;
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/cadastro.js"></script>
</body>
</html>