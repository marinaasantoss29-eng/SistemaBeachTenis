<?php
require_once "../utils/json_helper.php";

$nomes = $_POST["nome"] ?? [];
$apelidos = $_POST["apelido"] ?? [];
$formato = $_POST["formato"] ?? "";

$participantes = [];

for ($i = 0; $i < count($nomes); $i++) {
    $nome = trim($nomes[$i]);
    $apelido = trim($apelidos[$i]);

    if ($nome == "") {
        header("Location: cadastro.php");
        exit;
    }

    $participantes[] = [
        "id" => $i + 1,
        "nome" => $nome,
        "apelido" => $apelido
    ];
}

if (count($participantes) != 8) {
    header("Location: cadastro.php");
    exit;
}

gravar_json("../data/participantes.json", $participantes);

if ($formato == "") {
    header("Location: ../configuracao/configuracao.php");
    exit;
}

header("Location: ../configuracao/gerar_rodadas.php?formato=" . urlencode($formato));
exit;
?>
