<?php
// Inclui o arquivo de configuração gerado
include_once("settings.php");

// Carrega módulo de Key Lock (Descompactar senha segura)
include_once("keylock.php");

// Carrega Modulo de session
include_once('session.php');

// Carrega Modulo de funções e Classes
include_once('funcoes.class.php');

header("Content-Type: text/html; charset=utf-8");

// Outros cabeçalhos podem ser adicionados da mesma forma
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: no-referrer-when-downgrade");

// Carrega dados salvos
$lock = DB_PASS; // Aqui, usamos a constante definida no settings.php
$pass = sysDados_decrypt($lock, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');


// Função para criar uma nova conexão PDO
function createPDOConnection($dbname)
{
    // Descriptografa os dados do banco de dados
    $dbHost = sysDados_decrypt(DB_HOST, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');
    $dbUser = sysDados_decrypt(DB_USER, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');
    $dbPass = sysDados_decrypt(DB_PASS, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');
    $dbPort = sysDados_decrypt(DB_PORT, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');
    $sslMode = sysDados_decrypt(SSL_MODE, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==');

    // Cria a string de conexão DSN
    $dsn = "mysql:host=$dbHost;dbname=$dbname;port=$dbPort;SSL Mode=$sslMode";

    try {
        // Cria a conexão PDO
        $pdo = new PDO($dsn, $dbUser, $dbPass);

        // Define o modo de erro para Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // Trata o erro de conexão
        // echo 'Erro de conexão: ' . $e->getMessage();
        //  $errorMsg = 'Erro de conexão: ' . $e->getMessage();
        //    header("location: index?status=" . urlencode($errorMsg));
        return null;
    }
}

// Criar conexões
$pdo = createPDOConnection(sysDados_decrypt(DB_NAME, 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw=='));

// Função para gerar um token CSRF
function generateCSRFToken()
{
    return bin2hex(random_bytes(32));
}
