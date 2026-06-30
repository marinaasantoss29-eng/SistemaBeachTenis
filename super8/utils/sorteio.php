<?php

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

function obter_duplas_fixas($participantes) {
    return [
        [$participantes[0], $participantes[1]],
        [$participantes[2], $participantes[3]],
        [$participantes[4], $participantes[5]],
        [$participantes[6], $participantes[7]]
    ];
}

function obter_confrontos_duplas_fixas() {
    return [
        [[0, 1], [2, 3]],
        [[0, 2], [1, 3]],
        [[0, 3], [1, 2]],
        [[0, 1], [2, 3]],
        [[0, 2], [1, 3]],
        [[0, 3], [1, 2]],
        [[0, 1], [2, 3]]
    ];
}

?>