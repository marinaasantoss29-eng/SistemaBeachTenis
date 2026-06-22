<?php

function criar_ranking_inicial($participantes) {
    $ranking = [];

    foreach ($participantes as $p) {
        $ranking[$p["id"]] = [
            "id" => $p["id"],
            "nome" => $p["nome"],
            "jogos" => 0,
            "vitorias" => 0,
            "derrotas" => 0,
            "games_pro" => 0,
            "games_contra" => 0,
            "saldo" => 0,
            "pontos" => 0
        ];
    }

    return $ranking;
}

function calcular_ranking($participantes, $rodadas) {
    $ranking = criar_ranking_inicial($participantes);

    foreach ($rodadas as $rodada) {
        foreach ($rodada["partidas"] as $partida) {

            if ($partida["placarA"] === null || $partida["placarB"] === null) {
                continue;
            }

            $placarA = $partida["placarA"];
            $placarB = $partida["placarB"];

            foreach ($partida["duplaA"] as $jogador) {
                $id = $jogador["id"];

                $ranking[$id]["jogos"]++;
                $ranking[$id]["games_pro"] += $placarA;
                $ranking[$id]["games_contra"] += $placarB;
                $ranking[$id]["saldo"] = $ranking[$id]["games_pro"] - $ranking[$id]["games_contra"];

                if ($placarA > $placarB) {
                    $ranking[$id]["vitorias"]++;
                    $ranking[$id]["pontos"] += 2;
                } else {
                    $ranking[$id]["derrotas"]++;
                }

                $ranking[$id]["pontos"] += $placarA;
            }

            foreach ($partida["duplaB"] as $jogador) {
                $id = $jogador["id"];

                $ranking[$id]["jogos"]++;
                $ranking[$id]["games_pro"] += $placarB;
                $ranking[$id]["games_contra"] += $placarA;
                $ranking[$id]["saldo"] = $ranking[$id]["games_pro"] - $ranking[$id]["games_contra"];

                if ($placarB > $placarA) {
                    $ranking[$id]["vitorias"]++;
                    $ranking[$id]["pontos"] += 2;
                } else {
                    $ranking[$id]["derrotas"]++;
                }

                $ranking[$id]["pontos"] += $placarB;
            }
        }
    }

    usort($ranking, function($a, $b) {
        if ($b["pontos"] != $a["pontos"]) {
            return $b["pontos"] - $a["pontos"];
        }

        if ($b["saldo"] != $a["saldo"]) {
            return $b["saldo"] - $a["saldo"];
        }

        return $b["games_pro"] - $a["games_pro"];
    });

    return $ranking;
}

function calcular_pontos_partida(&$ranking, $partida) {
    if ($partida["placarA"] === null || $partida["placarB"] === null) {
        return;
    }

    $placarA = $partida["placarA"];
    $placarB = $partida["placarB"];

    foreach ($partida["duplaA"] as $jogador) {
        $id = $jogador["id"];
        $ranking[$id]["pontos"] += $placarA;

        if ($placarA > $placarB) {
            $ranking[$id]["pontos"] += 2;
        }
    }

    foreach ($partida["duplaB"] as $jogador) {
        $id = $jogador["id"];
        $ranking[$id]["pontos"] += $placarB;

        if ($placarB > $placarA) {
            $ranking[$id]["pontos"] += 2;
        }
    }
}

function calcular_evolucao_pontos($participantes, $rodadas) {
    $ranking = criar_ranking_inicial($participantes);
    $evolucao = [];

    foreach ($rodadas as $rodada) {
        foreach ($rodada["partidas"] as $partida) {
            calcular_pontos_partida($ranking, $partida);
        }

        $linha = [
            "rodada" => $rodada["numero"],
            "jogadores" => []
        ];

        foreach ($participantes as $p) {
            $linha["jogadores"][$p["id"]] = [
                "nome" => $p["nome"],
                "pontos" => $ranking[$p["id"]]["pontos"]
            ];
        }

        $evolucao[] = $linha;
    }

    return $evolucao;
}
?>
