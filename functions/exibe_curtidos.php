<?php

// Exibe todos os erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclua o arquivo de configuração do sistema
include_once("settings/includes.php");

// Certifique-se de que o usuário está autenticado e a variável $cpf_user está definida
iniciar_sessao();
if (!verificar_login()) {
    die("Erro: Usuário não autenticado.");
}

$cpf_user = $_SESSION[NAME_SESSION];

// Consulta para buscar todos os posts curtidos pelo usuário
$query = "
    SELECT 
        POST.*, 
        ACCOUNTS.nome AS autor_nome, 
        ACCOUNTS.FOTO_PERFIL AS autor_foto_perfil, 
        COALESCE(COUNT(CURTIDAS.ID), 0) AS total_curtidas
    FROM CURTIDAS
    JOIN POST ON CURTIDAS.post_id = POST.ID
    JOIN ACCOUNTS ON POST.CPF = ACCOUNTS.cpf
    WHERE CURTIDAS.cpf_usuario = :cpf_usuario
    GROUP BY POST.ID, ACCOUNTS.nome, ACCOUNTS.FOTO_PERFIL
    ORDER BY POST.ID DESC
";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cpf_usuario', $cpf_user);
    $stmt->execute();
    $postsCurtidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na consulta de posts curtidos: " . $e->getMessage());
}

?>

<!-- Contêiner pai para agrupar todos os posts curtidos -->
<div class="posts-wrapper">
    <h1>Interessados</h1>
    <?php if (empty($postsCurtidos)): ?>
        <p>Você ainda não curtiu nenhum post.</p>
    <?php else: ?>
        <?php foreach ($postsCurtidos as $post): ?>
            <?php
            // Formatar a data de criação do post
            try {
                $formatter = new IntlDateFormatter(
                    'pt_BR',
                    IntlDateFormatter::FULL,
                    IntlDateFormatter::NONE,
                    'America/Sao_Paulo',
                    IntlDateFormatter::GREGORIAN,
                    "d 'de' MMMM 'de' yyyy"
                );
                $dataFormatada = $formatter->format(new DateTime($post['DATA_CRIACAO']));
            } catch (Exception $e) {
                $dataFormatada = "Data inválida";
            }
            ?>
            <div class="post-container" data-post-id="<?php echo htmlspecialchars($post['ID']); ?>">
                <div class="post-header">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['autor_foto_perfil']); ?>" alt="Foto do Usuário"
                         class="profile-pic" id="profile-img">
                    <div class="header-info">
                        <h2><?php echo htmlspecialchars($post['autor_nome']); ?></h2>
                        <p class="post-date"><?php echo htmlspecialchars($dataFormatada); ?></p>
                    </div>
                </div>
                <div class="post-description">
                    <p class="description-text collapsed"><?php echo nl2br(htmlspecialchars($post['DESCRICAO'])); ?></p>
                    <button class="read-more-btn" onclick="toggleDescription(this)" style="display: none;">Ver mais</button>
                </div>
                <div class="post-image-container">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['POST_IMG']); ?>" alt="Imagem da Publicação"
                         class="post-image">
                </div>
                <div class="post-footer">
                    <span class="like-count"><?php echo htmlspecialchars($post['total_curtidas']); ?> Curtidas</span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Script para manipular a exibição e funcionalidade dos posts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.post-description').forEach(function (postDescription) {
            var descriptionText = postDescription.querySelector('.description-text');
            var readMoreBtn = postDescription.querySelector('.read-more-btn');

            // Cria um clone invisível do texto para calcular o número de linhas
            var clone = descriptionText.cloneNode(true);
            clone.style.display = 'block';
            clone.style.position = 'absolute';
            clone.style.visibility = 'hidden';
            clone.style.height = 'auto';
            clone.style.webkitLineClamp = 'unset';
            document.body.appendChild(clone);

            // Verifica o número de linhas
            if (clone.scrollHeight > descriptionText.clientHeight) {
                readMoreBtn.style.display = 'block';
            }

            document.body.removeChild(clone);
        });
    });

    function toggleDescription(button) {
        var description = button.previousElementSibling;
        description.classList.toggle('expanded');
        button.textContent = description.classList.contains('expanded') ? 'Ver menos' : 'Ver mais';
    }
</script>
