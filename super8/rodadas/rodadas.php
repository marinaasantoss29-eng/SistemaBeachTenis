<?php
require_once "../utils/json_helper.php";

$rodadas = ler_json("../data/rodadas.json");

if (empty($rodadas)) {
    header("Location: ../configuracao/configuracao.php");
    exit;
}

function rodada_completa($rodada) {
    foreach ($rodada["partidas"] as $partida) {
        if ($partida["placarA"] === null || $partida["placarB"] === null) {
            return false;
        }
    }

    return true;
}

function partidas_pendentes($rodada) {
    $pendentes = 0;

    foreach ($rodada["partidas"] as $partida) {
        if ($partida["placarA"] === null || $partida["placarB"] === null) {
            $pendentes++;
        }
    }

    return $pendentes;
}

$rodadaAtual = null;
$indiceRodada = null;
$indiceEdicao = isset($_GET["editar"]) ? intval($_GET["editar"]) : null;

if ($indiceEdicao !== null && isset($rodadas[$indiceEdicao])) {
    $rodadaAtual = $rodadas[$indiceEdicao];
    $indiceRodada = $indiceEdicao;
} else {
    foreach ($rodadas as $i => $rodada) {
        if (!rodada_completa($rodada)) {
            $rodadaAtual = $rodada;
            $indiceRodada = $i;
            break;
        }
    }
}

$modoEdicao = $indiceEdicao !== null && isset($rodadas[$indiceEdicao]);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Rodadas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h1>Lançamento de Placares</h1>

    <div class="status-rodadas">
        <?php foreach ($rodadas as $i => $rodada): ?>
            <?php
                $completa = rodada_completa($rodada);
                $classe = $completa ? "finalizada" : "pendente";

                if ($indiceRodada === $i) {
                    $classe = "atual";
                }
            ?>

            <div class="rodada-status <?= $classe ?>">
                <strong>R<?= $rodada["numero"] ?></strong>
                <span>
                    <?php if ($completa): ?>
                        Finalizada
                    <?php elseif ($indiceRodada === $i): ?>
                        Em andamento
                    <?php else: ?>
                        <?= partidas_pendentes($rodada) ?> partidas faltando
                    <?php endif; ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($rodadaAtual === null): ?>

        <div class="card">
            <h2>Todas as rodadas foram finalizadas!</h2>
            <p>Agora você pode ver a classificação final.</p>
        </div>

        <a href="../classificacao/classificacao.php">
            <button>Ver Classificação</button>
        </a>

    <?php else: ?>

        <h2>
            <?= $modoEdicao ? "Editar" : "Rodada" ?>
            <?= $rodadaAtual["numero"] ?> de 7
        </h2>
        <p>Formato: <?= ucfirst($rodadaAtual["formato"]) ?></p>

        <form action="salvar_placar.php" method="POST">
            <input type="hidden" name="indice_rodada" value="<?= $indiceRodada ?>">

            <?php foreach ($rodadaAtual["partidas"] as $indicePartida => $partida): ?>
                <div class="card">
                    <h3>Quadra <?= $partida["quadra"] ?></h3>

                    <p>
                        <strong>
                            <?= htmlspecialchars($partida["duplaA"][0]["nome"]) ?> /
                            <?= htmlspecialchars($partida["duplaA"][1]["nome"]) ?>
                        </strong>
                        X
                        <strong>
                            <?= htmlspecialchars($partida["duplaB"][0]["nome"]) ?> /
                            <?= htmlspecialchars($partida["duplaB"][1]["nome"]) ?>
                        </strong>
                    </p>

                    <input type="hidden" name="indice_partida[]" value="<?= $indicePartida ?>">

                    <label>Placar da Dupla A:</label>
                    <input
                        type="number"
                        name="placarA[]"
                        min="0"
                        max="4"
                        value="<?= htmlspecialchars($partida["placarA"] ?? "") ?>"
                        required
                    >

                    <label>Placar da Dupla B:</label>
                    <input
                        type="number"
                        name="placarB[]"
                        min="0"
                        max="4"
                        value="<?= htmlspecialchars($partida["placarB"] ?? "") ?>"
                        required
                    >
                </div>
            <?php endforeach; ?>

            <button type="submit">
                <?= $modoEdicao ? "Salvar Alterações do Placar" : "Salvar Placar da Rodada" ?>
            </button>
        </form>

    <?php endif; ?>

    <h2>Rodadas finalizadas</h2>

    <?php foreach ($rodadas as $i => $rodada): ?>
        <?php if (rodada_completa($rodada)): ?>
            <div class="card">
                <strong>Rodada <?= $rodada["numero"] ?></strong>
                <div class="acoes-rodada">
                    <a href="resultado_rodada.php?rodada=<?= $i ?>">Ver placar</a>
                    <a href="rodadas.php?editar=<?= $i ?>">Editar placar</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <br>
    <a href="../index.php">Voltar ao início</a>
</div>

</body>
</html>
