<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo 'includes.php' que carrega a função 'verificar_login'
include_once("settings/includes.php");

// Iniciar sessão e verificar login
iniciar_sessao();
if (verificar_login()) {
    $cpf_user  = $_SESSION[NAME_SESSION];
} else {
    $errorMsg = "Sua sessão expirou. Por favor, faça login novamente para continuar.";
     header("location: ../index?status=" . urlencode($errorMsg));
     exit();
}


// Criar a conexão PDO com o banco de dados
try {
    // Recuperando o nome completo e empresa do usuário com o CPF
    $usuarioManager = new UsuarioManager($pdo);  // Usando a conexão PDO válida
    $nome = $usuarioManager->obterNomePeloCPF($cpf_user);   

    // Recuperando o tema do usuário
    $stmt = $pdo->prepare("SELECT tema FROM ACCOUNTS WHERE cpf = :cpf_user");
    $stmt->bindParam(':cpf_user', $cpf_user, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se os valores foram retornados e definir padrões, se necessário
    $tema = $result['tema'] ?? 'theme-default';  // Caso não haja tema, utilizar o tema padrão

} catch (Exception $e) {
    // Em caso de erro, definir valores padrão
    $nome = 'Error_Name';
    $empresa = 'Error_Empresa';
    $tema = 'theme-default';

    // Exibir mensagem de erro para debug (não recomendado em produção)
    echo 'Erro: ' . $e->getMessage();  // Descomente esta linha para exibir detalhes do erro
}

?>
