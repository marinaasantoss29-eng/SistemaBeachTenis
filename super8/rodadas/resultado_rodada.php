<?php
require_once "../utils/json_helper.php";

$rodadas = ler_json("../data/rodadas.json");
$indiceRodada = isset($_GET["rodada"]) ? intval($_GET["rodada"]) : -1;

if (empty($rodadas) || !isset($rodadas[$indiceRodada])) {
    header("Location: rodadas.php");
    exit;
}

$rodada = $rodadas[$indiceRodada];
$rodadaCompleta = true;

foreach ($rodada["partidas"] as $partida) {
    if ($partida["placarA"] === null || $partida["placarB"] === null) {
        $rodadaCompleta = false;
        break;
    }
}

if (!$rodadaCompleta) {
    header("Location: rodadas.php");
    exit;
}

$ultimaRodada = $indiceRodada >= count($rodadas) - 1;
$proximoLink = $ultimaRodada ? "../classificacao/classificacao.php" : "rodadas.php";
$textoBotao = $ultimaRodada ? "Ver Classificação Geral" : "Ir para Próxima Rodada";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Rodada</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h1>Resultado da Rodada <?= htmlspecialchars($rodada["numero"]) ?></h1>

    <div class="card">
        <strong>Rodada encerrada com sucesso.</strong>
        <p>Confira os placares antes de continuar.</p>
    </div>

    <?php foreach ($rodada["partidas"] as $partida): ?>
        <div class="card">
            <h2>Quadra <?= htmlspecialchars($partida["quadra"]) ?></h2>

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

            <h2>
                <?= htmlspecialchars($partida["placarA"]) ?>
                x
                <?= htmlspecialchars($partida["placarB"]) ?>
            </h2>

            <?php if ($partida["placarA"] > $partida["placarB"]): ?>
                <p>
                    Vencedores:
                    <strong>
                        <?= htmlspecialchars($partida["duplaA"][0]["nome"]) ?> /
                        <?= htmlspecialchars($partida["duplaA"][1]["nome"]) ?>
                    </strong>
                </p>
            <?php elseif ($partida["placarB"] > $partida["placarA"]): ?>
                <p>
                    Vencedores:
                    <strong>
                        <?= htmlspecialchars($partida["duplaB"][0]["nome"]) ?> /
                        <?= htmlspecialchars($partida["duplaB"][1]["nome"]) ?>
                    </strong>
                </p>
            <?php else: ?>
                <p><strong>Partida empatada.</strong></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <a href="<?= $proximoLink ?>">
        <button><?= $textoBotao ?></button>
    </a>

    <br><br>
    <a href="rodadas.php?editar=<?= $indiceRodada ?>">
        <button>Editar Placar desta Rodada</button>
    </a>

    <br><br>
    <a href="../index.php">Voltar ao início</a>
</div>

</body>
</html>
