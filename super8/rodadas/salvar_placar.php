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

    if ($placarA < 0 || $placarA > 10 || $placarB < 0 || $placarB > 10) {
        echo "<script src='../js/ui.js'></script>
        <script>
            Super8UI.exibirAlerta('A pontuação deve ser de 0 até 10.');
            window.history.back();
        </script>";
        exit;
    }

    if ($placarA == $placarB) {
        echo "<script src='../js/ui.js'></script>
        <script>
            Super8UI.exibirAlerta('O sistema não aceita empate. Escolha uma dupla vencedora colocando 1 ponto a mais para ela.');
            window.history.back();
        </script>";
        exit;
    }

    $rodadas[$indiceRodada]["partidas"][$indicePartida]["placarA"] = $placarA;
    $rodadas[$indiceRodada]["partidas"][$indicePartida]["placarB"] = $placarB;
}

gravar_json("../data/rodadas.json", $rodadas);

header("Location: rodadas.php?editar=" . urlencode($indiceRodada) . "&salvo=1");
exit;
?>