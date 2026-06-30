<?php
require_once "../utils/json_helper.php";
require_once "../utils/sorteio.php";

$participantes = ler_json("../data/participantes.json");
$formato = $_POST["formato"] ?? $_GET["formato"] ?? "";

if (count($participantes) != 8 || $formato == "") {
    header("Location: configuracao.php");
    exit;
}

$rodadas = [];

$duplasRotativas = [];

if ($formato == "rotativas") {
    $duplasRotativas = gerar_duplas_rotativas_sem_repetir($participantes);
}

for ($r = 1; $r <= 7; $r++) {

    if ($formato == "rotativas") {
        $duplas = $duplasRotativas[$r - 1];

        $partida1 = [
            "quadra" => 1,
            "duplaA" => $duplas[0],
            "duplaB" => $duplas[1],
            "placarA" => null,
            "placarB" => null
        ];

        $partida2 = [
            "quadra" => 2,
            "duplaA" => $duplas[2],
            "duplaB" => $duplas[3],
            "placarA" => null,
            "placarB" => null
        ];
    } else {
        $duplas = obter_duplas_fixas($participantes);
        $confrontos = obter_confrontos_duplas_fixas();

        $partida1 = [
            "quadra" => 1,
            "duplaA" => $duplas[$confrontos[$r - 1][0][0]],
            "duplaB" => $duplas[$confrontos[$r - 1][0][1]],
            "placarA" => null,
            "placarB" => null
        ];

        $partida2 = [
            "quadra" => 2,
            "duplaA" => $duplas[$confrontos[$r - 1][1][0]],
            "duplaB" => $duplas[$confrontos[$r - 1][1][1]],
            "placarA" => null,
            "placarB" => null
        ];
    }

    $rodadas[] = [
        "numero" => $r,
        "formato" => $formato,
        "partidas" => [$partida1, $partida2]
    ];
}

gravar_json("../data/rodadas.json", $rodadas);

header("Location: ../rodadas/rodadas.php");
exit;
?>
