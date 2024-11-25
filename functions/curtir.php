<?php
include_once("../settings/includes.php");


// Iniciar sessão e verificar se o usuário está logado
iniciar_sessao();
if (!verificar_login()) {
    // Definir o cabeçalho como JSON e retornar erro de autorização
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

// Verificar se a variável $pdo está definida (conexão com o banco de dados)
if (!isset($pdo)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro de conexão com o banco de dados']);
    exit;
}

$post_id = $_POST['post_id'];
$cpf_user = $_SESSION[NAME_SESSION];

try {
    // Verificar se o usuário já curtiu o post
    $query = "SELECT * FROM CURTIDAS WHERE post_id = :post_id AND cpf_usuario = :cpf_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':cpf_usuario', $cpf_user);
    $stmt->execute();
    $curtidaExistente = $stmt->fetch();

    if ($curtidaExistente) {
        // Remover a curtida
        $query = "DELETE FROM CURTIDAS WHERE post_id = :post_id AND cpf_usuario = :cpf_usuario";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':cpf_usuario', $cpf_user);
        $stmt->execute();
        $curtido = false;
    } else {
        // Adicionar a curtida
        $query = "INSERT INTO CURTIDAS (post_id, cpf_usuario) VALUES (:post_id, :cpf_usuario)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':cpf_usuario', $cpf_user);
        $stmt->execute();
        $curtido = true;
    }

    // Contar o número total de curtidas
    $query = "SELECT COUNT(*) as CURTIDAS FROM CURTIDAS WHERE post_id = :post_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $contagemCurtidas = $stmt->fetchColumn();

    // Definir o cabeçalho como JSON e retornar o resultado
    header('Content-Type: application/json');
    echo json_encode(['curtidas' => $contagemCurtidas, 'curtido' => $curtido]);

} catch (PDOException $e) {
    // Em caso de erro com o banco de dados
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro ao processar a curtida: ' . $e->getMessage()]);
}
?>
