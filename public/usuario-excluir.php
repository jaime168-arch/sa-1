<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

// 1. Controle de Acesso: Apenas Administradores podem excluir usuários
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_tipo'] ?? '') !== 'admin') {
    $_SESSION['mensagem_erro'] = "Acesso negado. Apenas administradores podem excluir registros.";
    header("Location: usuarios.php");
    exit;
}

// 2. Validação do parâmetro ID recebido via GET
$idExcluir = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$idExcluir) {
    $_SESSION['mensagem_erro'] = "Identificador de usuário inválido.";
    header("Location: usuarios.php");
    exit;
}

// 3. Regra de Segurança: Bloqueia autoexclusão do próprio usuário logado
if ($idExcluir === (int)$_SESSION['usuario_id']) {
    $_SESSION['mensagem_erro'] = "Operação negada: Você não pode excluir a sua própria conta ativa.";
    header("Location: usuarios.php");
    exit;
}

try {
    // 4. Busca o usuário para verificar se existe e validar regras de negócio
    $stmtCheck = $pdo->prepare("SELECT id, email, tipo FROM usuarios WHERE id = :id LIMIT 1");
    $stmtCheck->execute([':id' => $idExcluir]);
    $usuario = $stmtCheck->fetch();

    if (!$usuario) {
        $_SESSION['mensagem_erro'] = "O usuário informado não existe na base de dados.";
        header("Location: usuarios.php");
        exit;
    }

    // 5. Regra do Sistema: Proteção do Administrador Principal (ID 1 ou e-mail admin)
    if ((int)$usuario['id'] === 1 || $usuario['email'] === 'admin@ismaga.com') {
        $_SESSION['mensagem_erro'] = "O Administrador Principal do sistema não pode ser excluído.";
        header("Location: usuarios.php");
        exit;
    }

    // 6. Execução da exclusão parametrizada (Segurança contra SQL Injection)
    $stmtDelete = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $sucesso = $stmtDelete->execute([':id' => $idExcluir]);

    if ($sucesso) {
        $_SESSION['mensagem_sucesso'] = "Usuário excluído com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Não foi possível excluir o usuário.";
    }

} catch (PDOException $e) {
    // Trata erros de chave estrangeira caso o usuário esteja associado a outra tabela
    if ($e->getCode() == '23000') {
        $_SESSION['mensagem_erro'] = "Não é possível excluir o usuário pois ele possui registros vinculados no sistema.";
    } else {
        $_SESSION['mensagem_erro'] = "Erro na base de dados: " . $e->getMessage();
    }
}

header("Location: usuarios.php");
exit;