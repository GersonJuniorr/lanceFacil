<?php
include_once("settings/includes.php");

// Configurar o Token desse APP
$tokenRHT = 'ADRIANO.RIQUETTI';

// Recupera o Token enviado no link encriptado
$token = $_GET['token'];
$token = sysDados_decrypt($token, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#164F61">
    <title>Instalar/Configurar Sistema</title>

    <link rel="icon" href="assets/img/favicon.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>       
        .border {
            border: 1px #164F61 !important;
          background-color: #eaeaea ;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h2>Configurações do Sistema</h2>
            </div>
            <div class="card-body">
                <?php if ($token != $tokenRHT): ?>
                    <div class="alert alert-danger text-center">
                        Token de instalação inválido ou ausente! Verifique os dados fornecidos.
                    </div>
                <?php else: ?>
                    <form action="settings/gerar_configuracoes.php" method="post">
                        <div class="form-row">
                            <!-- Versão do Site -->
                            <div class="form-group col-md-6">
                                <label for="version_site">Versão do Site</label>
                                <input type="text" class="form-control border" name="version_site" id="version_site" value="<?php echo VERSION; ?>" required>
                            </div>

                            <!-- Título das Páginas -->
                            <div class="form-group col-md-6">
                                <label for="page_title">Título das Páginas</label>
                                <input type="text" class="form-control border" name="page_title" id="page_title" value="<?php echo PAGE_TITLE; ?>" required>
                            </div>
                        </div>

                        <!-- Direitos Autorais -->
                        <div class="form-group">
                            <label for="copyright">Direitos Autorais</label>
                            <input type="text" class="form-control border" name="copyright" id="copyright" value="<?php echo COPYRIGHT; ?>" required>
                        </div>

                        <!-- Banco de Dados -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="db_host">Host do Banco de Dados</label>
                                <input type="text" class="form-control border" name="db_host" id="db_host" value="<?php echo sysDados_decrypt(DB_HOST, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="db_name">Nome do Banco de Dados</label>
                                <input type="text" class="form-control border" name="db_name" id="db_name" value="<?php echo sysDados_decrypt(DB_NAME, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>" required>
                            </div>
                        </div>

                     
                        <div class="form-row">
                            <!-- Usuário do Banco -->
                            <div class="form-group col-md-6">
                                <label for="db_user">Usuário do Banco de Dados</label>
                                <input type="text" class="form-control border" name="db_user" id="db_user" value="<?php echo sysDados_decrypt(DB_USER, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>" required>
                            </div>

                            <!-- Senha do Banco -->
                            <div class="form-group col-md-6">
                                <label for="db_pass">Senha do Banco de Dados</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border" name="db_pass" id="db_pass" value="<?php echo sysDados_decrypt(DB_PASS, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Porta e SSL -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="db_port">Porta do Banco de Dados</label>
                                <input type="text" class="form-control border" name="db_port" id="db_port" value="<?php echo sysDados_decrypt(DB_PORT, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ssl_mode">Modo SSL</label>
                                <input type="text" class="form-control border" name="ssl_mode" id="ssl_mode" value="<?php echo sysDados_decrypt(SSL_MODE, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='); ?>" required>
                            </div>
                        </div>

                        <!-- Sessão -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="SESSAO">Sessão Principal</label>
                                <input type="text" class="form-control border" name="SESSAO" id="SESSAO" value="<?php echo SESSAO; ?>" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sessao_name">Nome da Sessão</label>
                                <input type="text" class="form-control border" name="sessao_name" id="sessao_name" value="<?php echo NAME_SESSION; ?>" required>
                            </div>
                        </div>

                        <!-- Botão de Salvar -->
                        <button type="submit" class="btn btn-primary btn-block">Salvar Configurações</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Mostrar/Ocultar Senha
        $('#togglePassword').click(function() {
            let input = $('#db_pass');
            let icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
</body>

</html>