<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Incluir o arquivo de configuração do sistema
include_once("../settings/includes.php");

// Configurar Data e Hora local
date_default_timezone_set('America/Sao_Paulo');
$dataagora = date('d-m-Y H:i:s', time());

// Recuperar o CPF por GET
$login = $_GET['login'];

// Verifica se os valores foram recebidos do input
if (isset($login)) {
    // Validação dos campos
    if (empty($login)) {
        $errorMsg = "Erro ao validar dados de login. Usuário ou senha inválido.";
        header("Location: ../index?error=" . urlencode($errorMsg));
        exit();
    }
    try {
            $stmt = $pdo->prepare("SELECT cpf, status, tipo_acesso FROM ACCOUNTS WHERE cpf = :login");

        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user['status'] === 'ATIVO') {
            $cpf = $user['CPF'];          
                iniciar_sessao();
                criar_sessao(NAME_SESSION, $login);
                $mensagem = "Logado com sucesso!";
                header("Location: ../home.php?sucesso=" . urlencode($mensagem));            
        } else {
            $errorMsg = "Usuário bloqueado ou inativo no sistema. Por favor, entre em contato com o gestor.";
            header("Location: ../index?alerta=" . urlencode($errorMsg));
        }
    } catch (PDOException $e) {
        $errorMsg = "Erro no banco de dados: " . $e->getMessage();
        header("Location: ../index?error=" . urlencode($errorMsg));
        exit();
    }
} else {
    $errorMsg = "Erro ao validar dados de login. Usuário ou senha inválido.";
    header("Location: ../index?error=" . urlencode($errorMsg));
    exit();
}
