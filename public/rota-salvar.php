<?php
session_start();

// Aceita apenas envios via formulário (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: rotas.php');
    exit();
}

// Captura e limpa os dados recebidos
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$codigo = filter_input(INPUT_POST, 'codigo_rota', FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST, 'nome_rota', FILTER_SANITIZE_SPECIAL_CHARS);
$origem = filter_input(INPUT_POST, 'origem', FILTER_SANITIZE_SPECIAL_CHARS);
$destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
$distancia = filter_input(INPUT_POST, 'distancia_km', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$status = filter_input(INPUT_POST, 'status_rota', FILTER_SANITIZE_SPECIAL_CHARS);

// Validação dos campos obrigatórios
if (empty($codigo) || empty($nome) || empty($origem) || empty($destino)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos obrigatórios para salvar a rota.";
    header('Location: rota-form.php' . ($id ? "?id={$id}" : ""));
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
 *         $sql = $pdo->prepare("UPDATE rotas SET codigo = :codigo, nome = :nome, origem = :origem, destino = :destino, distancia_km = :distancia, status = :status WHERE id = :id");
 *         $sql->bindValue(':id', $id, PDO::PARAM_INT);
 *     } else {
 *         // Cadastra nova rota
 *         $sql = $pdo->prepare("INSERT INTO rotas (codigo, nome, origem, destino, distancia_km, status) VALUES (:codigo, :nome, :origem, :destino, :distancia, :status)");
 *     }
 * 
 *     $sql->bindValue(':codigo', $codigo);
 *     $sql->bindValue(':nome', $nome);
 *     $sql->bindValue(':origem', $origem);
 *     $sql->bindValue(':destino', $destino);
 *     $sql->bindValue(':distancia', $distancia);
 *     $sql->bindValue(':status', $status);
 *     $sql->execute();
 * 
 * } catch (PDOException $e) {
 *     $_SESSION['mensagem_erro'] = "Erro ao salvar a rota no banco de dados.";
 *     header('Location: rotas.php');
 *     exit();
 * }
 */

// Feedback temporário para testes na interface
if (!empty($id)) {
    $_SESSION['mensagem_sucesso'] = "Rota #{$id} atualizada com sucesso!";
} else {
    $_SESSION['mensagem_sucesso'] = "Nova rota cadastrada com sucesso!";
}

header('Location: rotas.php');
exit();