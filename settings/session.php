<?php
function iniciar_sessao()
{
    // Verifica se a sessão já está iniciada
    if (session_status() === PHP_SESSION_ACTIVE) {
        return; // Se a sessão já estiver iniciada, não faz nada e retorna
    }

    // Inicia a sessão
   // session_save_path('/var/tmp'); // Definir pasta do save

    session_start(['name' => SESSAO]); // Cria Sessão 
}

function criar_sessao($nome_var_sessao, $valor)
{
    // Inicia a sessão ou retoma a sessão atual
    iniciar_sessao();

    // Define a variável de sessão
    $_SESSION[$nome_var_sessao] = $valor;

    // Retorna true para indicar que a sessão foi criada com sucesso
    return true;
}
function verificar_login()
{
    // Inicia a sessão ou retoma a sessão atual
    iniciar_sessao();

    // Se estiver definida, o usuário está logado
    if (isset($_SESSION[NAME_SESSION])) {
        return true;
    } else {
        return false;
    }
}

function destruir_sessao() {   
    // Verifica se a sessão está ativa
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return; // Se a sessão não estiver ativa, sai da função
    }

    // Limpa todas as variáveis de sessão
    $_SESSION = array();

    // Se quiser destruir completamente a sessão, também precisa apagar o cookie de sessão
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destrói a sessão
    session_destroy();
}
?>