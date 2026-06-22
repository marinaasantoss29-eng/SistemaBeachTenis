<?php
require_once "../utils/json_helper.php";

$rodadas = ler_json("../data/rodadas.json");

$indiceRodada = $_POST["indice_rodada"] ?? null;
$indicesPartidas = $_POST["indice_partida"] ?? [];
$placaresA = $_POST["placarA"] ?? [];
$placaresB = $_POST["placarB"] ?? [];

if ($indiceRodada === null || empty($rodadas)) {
    header("Location: rodadas.php");
    exit;
}

for ($i = 0; $i < count($indicesPartidas); $i++) {
    $indicePartida = $indicesPartidas[$i];

    $placarA = intval($placaresA[$i]);
    $placarB = intval($placaresB[$i]);

    $rodadas[$indiceRodada]["partidas"][$indicePartida]["placarA"] = $placarA;
    $rodadas[$indiceRodada]["partidas"][$indicePartida]["placarB"] = $placarB;
}

gravar_json("../data/rodadas.json", $rodadas);

header("Location: resultado_rodada.php?rodada=" . urlencode($indiceRodada));
exit;
?>
