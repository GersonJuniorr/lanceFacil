<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir o arquivo de configuração do sistema
include_once("../settings/includes.php");


// Configurar Data e Hora local
date_default_timezone_set('America/Sao_Paulo');
$dataagora = date('d-m-Y H:i:s', time());



if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
    $fileName = $_FILES['profile_photo']['name'];
    $fileSize = $_FILES['profile_photo']['size'];
    $fileType = $_FILES['profile_photo']['type'];
    $id = $_POST['id']; // Certifique-se que $id está correto

    // Verifica se o arquivo é uma imagem válida (opcional, mas recomendado)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "Tipo de arquivo inválido. Apenas JPG, PNG são permitidos.";
        exit();
    }

    // Lê o conteúdo do arquivo
    $imgData = file_get_contents($fileTmpPath);

    // Prepara a consulta SQL para atualizar a imagem no banco de dados
    $sql = "UPDATE ACCOUNTS SET FOTO_PERFIL = :foto WHERE cpf    = :id";
    $stmt = $pdo->prepare($sql);

    // Liga os parâmetros da imagem e do ID
    $stmt->bindParam(':foto', $imgData, PDO::PARAM_LOB);  
    $stmt->bindParam(':id', $id, PDO::PARAM_STR); 

    if ($stmt->execute()) {
        $successMsg = "Foto enviada com sucesso!";
        header("Location: ../profile?status=" . urlencode($successMsg));
        exit();
    } else {
        echo "Erro ao atualizar a foto.";
    }
} else {
    echo "Erro no upload do arquivo.";
}
