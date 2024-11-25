<?php

// Carrega módulo de Key Lock (Descompactar senha segura)
include_once("keylock.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page_title = $_POST['page_title'] ?? '';
    $copyright = $_POST['copyright'] ?? '';
    $versao = $_POST['version_site'] ?? '';
    $sessaoPrincipal = $_POST['SESSAO'] ?? '';
    $sessao = $_POST['sessao_name'] ?? '';
    

    // Configurações do banco de dados
    $db_host = sysDados_encrypt($_POST['db_host'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_name = sysDados_encrypt($_POST['db_name'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_name2 = sysDados_encrypt($_POST['db_name2'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_name3 = sysDados_encrypt($_POST['db_name3'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_name4 = sysDados_encrypt($_POST['db_name4'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_name5 = sysDados_encrypt($_POST['db_name5'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_user = sysDados_encrypt($_POST['db_user'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_pass = sysDados_encrypt($_POST['db_pass'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $db_port = sysDados_encrypt($_POST['db_port'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    $ssl_mode = sysDados_encrypt($_POST['ssl_mode'] ?? '', 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB');
    
    // Atualize a variável $config_content
    $config_content = <<<EOD
    <?php
    // Configurações do Site
    define('PAGE_TITLE', '{$page_title}');
    define('COPYRIGHT', '{$copyright}');
    define('VERSION', '{$versao}');
    define('SESSAO', '{$sessaoPrincipal}');
    define('NAME_SESSION', '{$sessao}');
    
    // Configurações do Banco de Dados
    define('DB_HOST', '{$db_host}');
    define('DB_NAME', '{$db_name}');
    define('DB_NAME2', '{$db_name2}');
    define('DB_NAME3', '{$db_name3}');
    define('DB_NAME4', '{$db_name4}');
    define('DB_NAME5', '{$db_name5}');
    define('DB_USER', '{$db_user}');
    define('DB_PASS', '{$db_pass}');
    define('DB_PORT', '{$db_port}');
    define('SSL_MODE', '{$ssl_mode}');
    // FIM - by Adriano Riquetti
    ?>
    EOD;

    $file_path = 'settings.php';

    // Verifica se o arquivo existe e apaga
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    if (file_put_contents($file_path, $config_content) !== false) {
        header("location: ../index?sucess");
    } else {
        echo "Erro ao gerar o arquivo de configuração.";
        $errorMsg = "Erro ao gerar o arquivo de configuração.";
        header("location: ../index?status=" . urlencode($errorMsg));
    }
}
