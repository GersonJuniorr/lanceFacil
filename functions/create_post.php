<?php

// Cabeçalho para garantir que o retorno seja JSON
header('Content-Type: application/json');

// Incluir o arquivo de configuração do sistema
include_once("../settings/includes.php");

// Configurar Data e Hora local
date_default_timezone_set('America/Sao_Paulo');
$dataagora = date('d-m-Y H:i:s', time());

// Iniciar sessão e verificar login
iniciar_sessao();  // Função definida em 'session.php'

if (!verificar_login()) {
    echo json_encode(['success' => false, 'message' => 'Sua sessão expirou. Por favor, faça login novamente.']);
    exit();
}

$cpf_user = $_SESSION[NAME_SESSION];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $dataCriacao = date('Y-m-d');

    // Processa o upload da imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $imgData = file_get_contents($fileTmpPath);

        if ($imgData !== false) {
            try {
                // Insere o post no banco de dados, incluindo se é um comunicado
                $stmt = $pdo->prepare("INSERT INTO POST (CPF, DESCRICAO, POST_IMG, DATA_CRIACAO) 
                                       VALUES (:user_id, :description, :post_img, :data_criacao)");
                $stmt->bindParam(':user_id', $cpf_user);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':post_img', $imgData, PDO::PARAM_LOB);
                $stmt->bindParam(':data_criacao', $dataCriacao);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Post criado com sucesso!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erro ao criar post no banco de dados.']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao carregar a imagem.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem: ' . $_FILES['image']['error']]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método HTTP inválido.']);
}
