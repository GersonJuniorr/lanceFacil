<?php  include_once('pages/page.php') ?>
<!doctype html>
<html lang="en">

<head>
<?php include_once('pages/head.php')?>
</head>

<body class="body-scroll <?= htmlspecialchars($tema) ?>" data-page="">

    <?php include_once("pages/loader.php"); ?>


    <!-- Begin page -->
    <main class="h-100 has-header main-color">

        <!-- Pages -->
        <?php include_once("pages/header.php"); ?>

        <?php include_once("pages/loader.php"); ?>

        <?php include_once("pages/sidebar.php"); ?>
        <!-- Pages -->

        <!-- main page content -->
        <div class="main-container container">

            <div class="section mt-3 text-center">
                <div class="avatar-section">
                    <a href="alterar_imagem.php">
                        <img src="imagem.php?id=<?php echo $cpf_user; ?>" alt="" class="imaged w48">
                        <span class="button">
                            <ion-icon name="camera-outline"></ion-icon>
                        </span>
                    </a>
                </div>
            </div>

            <div class="listview-title mt-1">Perfil</div>
            <ul class="listview image-listview text inset">
                <li>
                    <a href="#" class="item">
                        <div class="in">
                            <div>Nome:
                                <?PHP echo $nome; ?>
                            </div>
                        </div>
                    </a>
                </li>

            </ul>


            <div class="listview-title mt-1">Conta</div>
            <ul class="listview image-listview text mb-2 inset">
                <li>
                    <a class="item" href="#" tabindex="-1" onclick="Evento()">

                        <div class="in">Sair do aplicativo</div>

                    </a>
                </li>
            </ul>

        </div>


        <!-- menu section -->
        <?php include("pages/menu.php"); ?>
        <!-- menu section -->

    </main>
    <!-- Page ends-->

    <script>
        function changeTheme() {
            var selectedTheme = document.getElementById('theme-selector').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "functions/salvar_tema.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log("Tema atualizado com sucesso");

                    location.reload();
                }
            };
            xhr.send("theme=" + selectedTheme);
        }
        function changeModo() {
            var selectedModo = document.getElementById('modo-selector').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "functions/salvar_tema.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log("Modo atualizado com sucesso");

                    location.reload();
                }
            };
            xhr.send("modo=" + selectedModo);
        }

    </script>



    <script>
        function Evento() {
            window.location.href = "logout";
        }
    </script>

<?php include_once('pages/scripts.php')  ?>



</body>

</html>