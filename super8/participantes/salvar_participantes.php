<?php
require_once "../utils/json_helper.php";

$nomes = $_POST["nome"] ?? [];
$apelidos = $_POST["apelido"] ?? [];
$formato = $_POST["formato"] ?? "";

$participantes = [];
$nomesVerificados = [];

function voltar_para_cadastro($formato) {
    $url = "cadastro.php";

    if ($formato != "") {
        $url .= "?formato=" . urlencode($formato);
    }

    header("Location: " . $url);
    exit;
}

for ($i = 0; $i < count($nomes); $i++) {
    $nome = trim($nomes[$i]);
    $apelido = trim($apelidos[$i]);

    if ($nome == "") {
        voltar_para_cadastro($formato);
    }

    $nomeMinusculo = mb_strtolower($nome, "UTF-8");

    if (in_array($nomeMinusculo, $nomesVerificados)) {
        echo "<script>
            alert('Não é permitido cadastrar nomes iguais.');
            window.location.href = 'cadastro.php?formato=" . htmlspecialchars($formato, ENT_QUOTES, "UTF-8") . "';
        </script>";
        exit;
    }

    $nomesVerificados[] = $nomeMinusculo;

    $participantes[] = [
        "id" => $i + 1,
        "nome" => $nome,
        "apelido" => $apelido
    ];
}

if (count($participantes) != 8) {
    voltar_para_cadastro($formato);
}

gravar_json("../data/participantes.json", $participantes);

if ($formato == "") {
    header("Location: ../configuracao/configuracao.php");
    exit;
}

header("Location: ../configuracao/gerar_rodadas.php?formato=" . urlencode($formato));
exit;
?>