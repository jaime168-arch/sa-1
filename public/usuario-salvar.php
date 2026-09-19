<?php
// Inicia a sessão para persistir mensagens de feedback
session_start();

// Garante que o acesso ocorra exclusivamente via método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: usuarios.php');
    exit();
}

// Resgate e higienização dos campos enviados pelo formulário
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$senha = $_POST['senha'] ?? null;

// Validação dos campos obrigatórios
if (empty($nome) || empty($email) || empty($tipo)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios corretamente.";
    header('Location: usuario-form.php' . ($id ? "?id=$id" : ""));
    exit();
}

/* 
 * Lógica de Persistência no Banco de Dados (MySQL / PDO)
 * 
 * Exemplo de implementação real com PDO:
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "usuario", "senha");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     if (!empty($id)) {
 *         // Atualização de Usuário Existente
 *         if (!empty($senha)) {
 *             $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
 *             $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, senha = :senha WHERE id = :id");
 *             $stmt->bindValue(':senha', $hashSenha);
 *         } else {
 *             $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
 *         }
 *         $stmt->bindValue(':id', $id, PDO::PARAM_INT);
 *     } else {
 *         // Inserção de Novo Usuário
 *         $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
 *         $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, tipo, senha) VALUES (:nome, :email, :tipo, :senha)");
 *         $stmt->bindValue(':senha', $hashSenha);
 *     }
 * 
 *     $stmt->bindValue(':nome', $nome);
 *     $stmt->bindValue(':email', $email);
 *     $stmt->bindValue(':tipo', $tipo);
 *     $stmt->execute();
 * 
 * } catch (PDOException $e) {
 *     $_SESSION['mensagem_erro'] = "Erro de conexão com o banco de dados.";
 *     header('Location: usuarios.php');
 *     exit();
 * }
 */

// Mensagem de sucesso simulada
if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Usuário #{$id} atualizado com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso!";
}

// Redireciona para a listagem/gestão de usuários
header('Location: usuarios.php');
exit();