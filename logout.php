<?php
// Incluir o arquivo de configuração do sistema
include_once("settings/includes.php");

// Criar sessão e enviar para app-home
iniciar_sessao();

// Fecha sessões e limpa o cache
destruir_sessao();
clearstatcache(); //LIMPAR CACHE

  $errorMsg = "Logout realizado com sucesso!";
  header("location: index?mensagem=" . urlencode($errorMsg));
?>