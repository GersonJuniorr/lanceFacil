<?php 
include_once('pages/page.php');
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?php include_once('pages/head.php')?>
</head>

<body class="<?= htmlspecialchars($tema) ?> main-color" data-page="home">

    <?php 
    include_once("pages/loader.php"); ?>

    <?php include_once("pages/sidebar.php"); ?>

    <!-- Begin page -->
    <main class="h-100 has-header has-footer">

        <!-- Header -->
        <?php include_once("pages/header.php"); ?>

        <!-- Header ends -->
        <!-- main page content -->
        <div class="main-container container">


            <!-- categories -->
            <div class="swiper-container categoriesswiper mb-3">
                <!-- Additional required wrapper -->
                <div class="row">

                    <?php  include("functions/exibe_curtidos.php"); ?>

                </div>

                <!-- Categories -->

            </div>
            <!-- main page content ends -->


    </main>
    <!-- Page ends-->

    <?php include_once('pages/menu.php'); ?>

    <!-- Footer ends-->


   <?php include_once('pages/scripts.php') ?>


</body>

</html>