<?php

function sysDados_decrypt($valor, $token)
{
   $tokenAPI = 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcw==';
   if ($token == $tokenAPI) {
      $responseData = base64_decode($valor); // Resultado da API
      return $responseData;
   } else {
      return '';
   }
}
function sysDados_encrypt($valor, $token)
{
   $tokenAPI = 'Q2Fyc3RlbiBTZXJ2acOnb3MgZSBUcmFuc3BvcnRlcyBMVERB';
   if ($token == $tokenAPI) {
      $responseData = base64_encode($valor); // Resultado da API
      return $responseData;
   } else {
      return '';
   }
}
