<?php
require_once "../utils/json_helper.php";

$participantes = ler_json("../data/participantes.json");
$formato = $_POST["formato"] ?? $_GET["formato"] ?? "";

if (count($participantes) != 8 || $formato == "") {
    header("Location: configuracao.php");
    exit;
}

$rodadas = [];

function gerar_duplas_rotativas_sem_repetir($participantes) {
    shuffle($participantes);

    $fixo = $participantes[0];
    $rotacao = array_slice($participantes, 1);
    $rodadasDuplas = [];

    for ($r = 1; $r <= 7; $r++) {
        $jogadores = array_merge([$fixo], $rotacao);
        $duplas = [];

        for ($i = 0; $i < 4; $i++) {
            $duplas[] = [
                $jogadores[$i],
                $jogadores[7 - $i]
            ];
        }

        $rodadasDuplas[] = $duplas;

        $ultimo = array_pop($rotacao);
        array_unshift($rotacao, $ultimo);
    }

    return $rodadasDuplas;
}

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
        $duplas = [
            [$participantes[0], $participantes[1]],
            [$participantes[2], $participantes[3]],
            [$participantes[4], $participantes[5]],
            [$participantes[6], $participantes[7]]
        ];

        $confrontos = [
            [[0, 1], [2, 3]],
            [[0, 2], [1, 3]],
            [[0, 3], [1, 2]],
            [[0, 1], [2, 3]],
            [[0, 2], [1, 3]],
            [[0, 3], [1, 2]],
            [[0, 1], [2, 3]]
        ];

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
