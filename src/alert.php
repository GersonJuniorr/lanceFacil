<?php
if (isset($_GET['mensagem']) && $_GET['mensagem'] !== '') {
    echo "<script>statusInfo('" . $_GET['mensagem'] . "');</script>";
} elseif (isset($_GET['alerta']) && $_GET['alerta'] !== '') {
    echo "<script>statusAlert('" . $_GET['alerta'] . "');</script>";
} elseif (isset($_GET['error']) && $_GET['error'] !== '') {
    echo "<script>statusError('" . $_GET['error'] . "');</script>";
} elseif (isset($_GET['token']) && $_GET['token'] !== '') {
    echo "<script>statusToken('" . $_GET['token'] . "');</script>";
}elseif (isset($_GET['sucesso']) && $_GET['sucesso'] !== '') {
    echo "<script>statusSucesso('" . $_GET['sucesso'] . "');</script>";
}
