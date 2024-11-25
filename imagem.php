<?php
// Incluir o arquivo de configuração do sistema
include_once("settings/includes.php");

// pegando CPF por GET
$username = $_GET['id'];

// Selecionando a foto pelo CPF do motorista
$stmt = $pdo->prepare("SELECT FOTO_PERFIL FROM ACCOUNTS WHERE cpf='$username'");

// Se executado
if ($stmt->execute()) {
    // Alocando foto para verificar se existi
    $foto = $stmt->fetchObject();
    if ($foto->FOTO_PERFIL != '') {
        #SE EXISTIR A FOTO EXIBI:
        header('Content-Type: image/jpeg');
        echo $foto->FOTO_PERFIL;
    } else {
        #SE NÃO EXISITIR A FOTO, EXIBI A PADRÃO:
        $stmt2 = $pdo2->prepare("SELECT FOTO_PERFIL FROM ACCOUNTS WHERE cpf='1'");
        if ($stmt2->execute()) {

            $foto2 = $stmt2->fetchObject();
            header('Content-Type: image/jpeg');
            echo $foto2->FOTO_PERFIL;
        }
    }
}else {
    #SE NÃO EXISITIR A FOTO, EXIBI A PADRÃO:
    $stmt2 = $pdo2->prepare("SELECT FOTO_PERFIL FROM ACCOUNTS WHERE cpf='1'");
    if ($stmt2->execute()) {

        $foto2 = $stmt2->fetchObject();
        header('Content-Type: image/jpeg');
        echo $foto2->FOTO_PERFIL;
    }
}

?><html>
<meta Http-Equiv="Cache-Control" Content="no-cache">
<meta Http-Equiv="Pragma" Content="no-cache">
<meta Http-Equiv="Expires" Content="0">
<meta Http-Equiv="Pragma-directive: no-cache">


</html>