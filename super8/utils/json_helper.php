<?php

function ler_json($caminho) {
    if (!file_exists($caminho)) {
        return [];
    }

    $conteudo = file_get_contents($caminho);

    if (empty($conteudo)) {
        return [];
    }

    $dados = json_decode($conteudo, true);

    if ($dados === null) {
        return [];
    }

    return $dados;
}

function gravar_json($caminho, $dados) {
    $json = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($caminho, $json);
}
?>