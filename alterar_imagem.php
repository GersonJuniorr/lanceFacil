<?php  include_once('pages/page.php') ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title><?php echo PAGE_TITLE; ?></title>
    <meta name="description" content="WINE Profile">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link rel="manifest" href="__manifest.json">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <style>
        .progress-bar {
            width: 100%;
            background-color: #1DCC70;
            border-radius: 20px;
            animation: progressAnimation 5s infinite;
        }

        @keyframes progressAnimation {
            0% {
                width: 0%;
            }

            50% {
                width: 50%;
            }

            100% {
                width: 100%;
            }
        }
    </style>
</head>
<script>
    function Evento() {
        window.location.href = "index.php";
    }
</script>

<body>

    <!-- loader -->

    <!-- * loader -->

    <!-- App Header -->
    <div class="container-fluid header">
        <div class="col-auto">
            <button type="button" class="goBack btn btn-link menu-btn text-color-theme">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </button>
        </div>
        <div class="col text-center header-profile textimg-header">Inserir imagem</div>
        <div class="right"></div>
    </div>



    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section mt-3 text-center">
            <div class="avatar-section">
                <img src="imagem.php?id=<?php echo $cpf_user; ?>" id="imagemPreview" alt="avatar" class="imaged w48">
            </div>
        </div>
        <br>
        <div class="section mt-3">
            <div class="stat-box">
                <div class="title">Imagem:</div>
                <form action="functions/upload_foto.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $cpf_user; ?>">
                    <input class="custom-file-input" type="file" name="profile_photo" id="arquivoInput"
                        onchange="exibirPreview()" accept="image/*">
                    <div id="imagemEscolhida" class="text-success"> Nenhum arquivo selecionado</div>
                    <p></p>
                    <div id="aguardeMensagem" style="display: none;" class="text">
                        <hr>
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Enviando...</div>
                    </div>
                    <br />
                </form>

            </div>
        </div>
        <br>
    </div>
    <script>
        function exibirNomeArquivoEscolhido() {
            // Obtém o input de arquivo
            var input = document.getElementById('arquivoInput');

            // Verifica se algum arquivo foi selecionado
            if (input.files && input.files.length > 0) {
                // Obtém o nome do arquivo selecionado
                var nomeArquivo = input.files[0].name;

                // Exibe o nome do arquivo escolhido na div 'imagemEscolhida'
                document.getElementById('imagemEscolhida').textContent = 'Arquivo escolhido: ' + nomeArquivo;
            } else {
                // Se nenhum arquivo foi selecionado, exibe uma mensagem padrão
                document.getElementById('imagemEscolhida').textContent = 'Nenhum arquivo selecionado';
            }
        }

        // Chama a função exibirNomeArquivoEscolhido() quando um arquivo for selecionado
        document.getElementById('arquivoInput').addEventListener('change', exibirNomeArquivoEscolhido);

        function exibirMensagemAguarde() {
            document.getElementById('aguardeMensagem').style.display = 'block';
        }

        function exibirPreview() {
            const arquivoInput = document.getElementById('arquivoInput');
            const imagemPreview = document.getElementById('imagemPreview');
            if (arquivoInput.files && arquivoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagemPreview.src = e.target.result;
                }
                reader.readAsDataURL(arquivoInput.files[0]);
            }
        }
    </script>
    <br />
    <!-- * App Capsule -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="assets/js/plugins/splide/splide.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>
    <script src="script.js"></script>



</body>

</html>