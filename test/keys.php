<?php
function gerarChaveUnica($tamanho = 10) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';
    $chave = '';

    for ($i = 0; $i < $tamanho; $i++) {
        $chave .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }

    return $chave;
}

// Exemplo de uso: gerar uma chave de 24 caracteres
$chaveUnica = gerarChaveUnica(24);
echo $chaveUnica;