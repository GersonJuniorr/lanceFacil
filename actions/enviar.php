<?php

// Incluir o arquivo de configuração do sistema
include_once("../settings/includes.php");

// Configurar Data e Hora local
date_default_timezone_set('America/Sao_Paulo');
$dataagora = date('d-m-Y H:i:s', time());

// Verifica se os valores foram recebidos do input
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $login = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $pass = md5(htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8'));

    // Validação dos campos
    if (empty($login) || empty($pass)) {
        $errorMsg = "Por favor, preencha todos os campos antes de continuar.";
        header("Location: ../index?alerta=" . urlencode($errorMsg));
        exit();
    }
    // Criar sessão e enviar para app-home
    iniciar_sessao();
    // Verifica se o token CSRF enviado no formulário corresponde ao token armazenado na sessão
    if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
        // Token CSRF inválido, rejeita a solicitação
        $errorMsg = "O token CSRF é inválido. Por favor, feche o aplicativo e abra novamente ou recarregue a página.";
        header("location: ../index?token=" . urlencode($errorMsg) . "&csrf=true");
    } else {
        // echo 'Sucesso ::: Post: ' . $_POST['csrf_token'] . ' - Session: ' . $_SESSION['csrf_token'];
        try {           
            // Consulta banco de dados
            $stmt = $pdo->prepare('SELECT * FROM ACCOUNTS WHERE cpf = :login AND senha = :sen');
            $stmt->execute([':login' => $login, ':sen' => $pass]);

            $count = $stmt->rowCount();
            if ($count > 0) {
                header("Location: validar?login=" . $login);
                exit();
            } else {
                $errorMsg = "Usuário ou senha inválidos. Verifique suas credenciais e tente novamente.";
                header("Location: ../index?error=" . urlencode($errorMsg));
                exit();
            }
        } catch (PDOException $e) {
            $errorMsg = "Erro no banco de dados: " . $e->getMessage();
            header("Location: ../index?alerta=" . urlencode($errorMsg));
            exit();
        }
    }
} else {
    $errorMsg = "Por favor, preencha todos os campos antes de continuar.";
    header("Location: ../index?alerta=" . urlencode($errorMsg));
    exit();
}
