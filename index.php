<?php
// Incluir o arquivo de configuração do sistema
include_once("settings/includes.php");
include_once("settings/funcoes.class.php");


// Verifica se o token CSRF foi invalidado
$csrf = $_GET['csrf'] ?? '';
if ($csrf === 'true') {
    destruir_sessao();
    clearstatcache(); // Limpar cache

    // Criar sessão, se necessário
    iniciar_sessao();

    // Verifica se o cookie CSRF está presente e, se não, gera um novo
    $tokenCSRF = generateCSRFToken();
    criar_sessao('csrf_token', $tokenCSRF);
} else {
    // Criar sessão, se necessário
    iniciar_sessao();

    // Verifica se a variável de sessão 'usuario' está definida
    if (isset($_SESSION[NAME_SESSION])) {
        header("Location: actions/validar?cpf=" . $_SESSION[NAME_SESSION]);
        exit(); // Adicione exit() após redirecionamento para garantir que o script pare de ser executado
    } else {
        // A sessão não é válida, destruir a sessão
        $_SESSION[NAME_SESSION] = null;
        clearstatcache();

        // Criar sessão, se necessário
        iniciar_sessao();

        // Verifica se o cookie CSRF está presente e, se não, gera um novo
        $tokenCSRF = generateCSRFToken();
        criar_sessao('csrf_token', $tokenCSRF);
    }
}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php include_once('src/head.php'); ?>
    <?php include_once('src/head_login.php'); ?>
</head>

<body>
    

    <div class="container-login">
        <div class="intro_bem-vindo">
            <span class="bem-vindo">
                <h1>Seja bem-vindo(a)!</h1>
            </span>

            <span>
                <p>Utilize as credenciais do seu acesso fornecida pelo time do suporte.</p>
            </span>
        </div>

        <div class="intro_login">
            <span class="login">
                <h1>Login</h1>
            </span>

            <div class="form-container">
                <form class="form-container" action="actions/enviar.php" method="POST">
                    <div class="form-group">
                        <input type="text" oninput="mascara(this)" id="username" name="username" placeholder="000.000.000-00" autocomplete="000.000.000-00" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Senha" required autocomplete="new-password">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $tokenCSRF; ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-login">LOGIN</button>
                    </div>
                    <p><a href="#" target="_self" class="rota">Esqueceu a senha?</a></p>
                </form>
            </div>

            <footer class="footer">
                <a href="#" class="rota">Inside Solutions©</a>
                <br>
                Todos os direitos reservados
            </footer>

        </div>
    </div>


    <!-- ========= JS Files =========  -->
    <?php include_once('src/jsfiles.php') ?>
    <!-- * ========= JS Files =========  -->

    <!-- ========= Verifica Alerta =========  -->
    <?php include_once('src/alert.php') ?>
    <!-- * ========= Verifica Alerta =========  -->

    <script>
        //  <!-- Adiciona ao Home com atraso de 2 segundos. -->
        AddtoHome("1500", "once");
        // <!--  * Adiciona ao Home com atraso de 2 segundos. -->
    </script>
</body>

</html>