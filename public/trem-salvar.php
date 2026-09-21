<?php
session_start();

// Aceita apenas envios via formulário (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: trens.php');
    exit();
}

// Captura e limpa os dados recebidos do formulário
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST, 'nome_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_NUMBER_INT);
$status = filter_input(INPUT_POST, 'status_trem', FILTER_SANITIZE_SPECIAL_CHARS);
$modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_SPECIAL_CHARS);

// Validação dos campos obrigatórios
if (empty($codigo) || empty($nome) || empty($capacidade) || empty($status)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar o trem.";
    header('Location: trem-form.php' . ($id ? "?id={$id}" : ""));
    exit();
}

/*
 * Integração com o Banco de Dados (MySQL)
 * 
 * try {
 *     $pdo = new PDO("mysql:host=localhost;dbname=ja_ismaga;charset=utf8mb4", "root", "");
 *     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 * 
 *     if (!empty($id)) {
 *         // Atualiza registro existente
 *         $sql = $pdo->prepare("UPDATE trens SET 
 *             codigo = :codigo, 
 *             nome = :nome, 
 *             capacidade = :capacidade, 
 *             status = :status, 
 *             modelo = :modelo 
 *             WHERE id = :id");
 *         $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     } else {
 *         // Cadastra novo trem
 *         $sql = $pdo->prepare("INSERT INTO trens 
 *             (codigo, nome, capacidade, status, modelo) 
 *             VALUES (:codigo, :nome, :capacidade, :status, :modelo)");
 *     }
 * 
 *     $sql->bindValue(':codigo', $codigo);
 *     $sql->bindValue(':nome', $nome);
 *     $sql->bindValue(':capacidade', $capacidade, PDO::PARAM_INT);
 *     $sql->bindValue(':status', $status);
 *     $sql->bindValue(':modelo', $modelo);
 *     $sql->execute();
 * 
 * } catch (PDOException $e) {
 *     $_SESSION['mensagem_erro'] = "Erro ao salvar as informações do trem no banco de dados.";
 *     header('Location: trens.php');
 *     exit();
 * }
 */

// Feedback temporário para testes na interface
if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Trem #{$id} atualizado com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Novo trem cadastrado com sucesso!";
}

header('Location: trens.php');
exit();