<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

// Captura e limpa os dados enviados
$nome  = trim($_POST['nome'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

// Validar se os campos estão preenchidos
if (empty($nome) || !$email || empty($senha)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos corretamente.";
    header("Location: cadastro.php");
    exit;
}

// Validar se as senhas coincidem
if ($senha !== $confirmar_senha) {
    $_SESSION['mensagem_erro'] = "As palavras-passes não coincidem.";
    header("Location: cadastro.php");
    exit;
}

try {
    // 1. Verificar se o e-mail já existe na base de dados
    $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmtCheck->bindValue(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        $_SESSION['mensagem_erro'] = "Este e-mail já está registado.";
        header("Location: cadastro.php");
        exit;
    }

    // 2. Gerar Hash seguro da palavra-passe
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // 3. Inserir o novo utilizador
    $stmtInsert = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
    $stmtInsert->bindValue(':nome', $nome);
    $stmtInsert->bindValue(':email', $email);
    $stmtInsert->bindValue(':senha', $senhaHash);
    $stmtInsert->execute();

    // 4. Redirecionar para o LOGIN com mensagem de sucesso
    $_SESSION['mensagem_sucesso'] = "Conta criada com sucesso! Faça login para continuar.";
    header("Location: login.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro ao guardar no banco de dados: " . $e->getMessage();
    header("Location: cadastro.php");
    exit;
}
?>