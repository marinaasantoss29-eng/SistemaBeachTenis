<?php
require_once "../utils/json_helper.php";
require_once "../utils/pontuacao.php";

$participantes = ler_json("../data/participantes.json");
$rodadas = ler_json("../data/rodadas.json");

if (empty($participantes) || empty($rodadas)) {
    header("Location: ../index.php");
    exit;
}

$ranking = calcular_ranking($participantes, $rodadas);
$evolucao = calcular_evolucao_pontos($participantes, $rodadas);
$campeao = $ranking[0];
$maiorPontuacao = max(array_column($ranking, "pontos"));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Classificação</title>
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body>

<div class="container">
    <h1>Tabela de Classificação</h1>

    <div class="card">
        <h2>🏆 Campeão Atual</h2>
        <p>
            <strong><?= htmlspecialchars($campeao["nome"]) ?></strong><br>
            Pontos: <?= $campeao["pontos"] ?><br>
            Vitórias: <?= $campeao["vitorias"] ?><br>
            Saldo de games: <?= $campeao["saldo"] ?>
        </p>
    </div>

    <p>
        Regra usada: vitória vale <strong>+2 pontos</strong> e cada game vencido vale
        <strong>+1 ponto</strong>.
    </p>

    <p>
        Critério de desempate: maior pontuação, depois maior saldo de games,
        depois maior número de games vencidos.
    </p>

    <div class="acoes-classificacao">
        <button onclick="window.print()">Imprimir Classificação</button>
        <a href="exportar_classificacao.php">
            <button>Exportar HTML</button>
        </a>
    </div>

    <h2>Evolução dos Jogadores</h2>

    <div class="grafico-evolucao">
        <?php foreach ($ranking as $posicao => $jogador): ?>
            <?php
                $largura = $maiorPontuacao > 0 ? ($jogador["pontos"] / $maiorPontuacao) * 100 : 0;
            ?>
            <div class="linha-grafico">
                <div class="posicao-grafico"><?= $posicao + 1 ?>º</div>

                <div class="jogador-grafico">
                    <strong><?= htmlspecialchars($jogador["nome"]) ?></strong>
                    <span>
                        <?= $jogador["vitorias"] ?> vitórias ·
                        saldo <?= $jogador["saldo"] ?>
                    </span>
                </div>

                <div class="barra-grafico" aria-label="<?= $jogador["pontos"] ?> pontos">
                    <div style="width: <?= $largura ?>%"></div>
                </div>

                <strong class="pontos-grafico"><?= $jogador["pontos"] ?> pts</strong>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="table-responsive">
        <table>
            <tr>
                <th>Posição</th>
                <th>Jogador</th>
                <th>Partidas</th>
                <th>Vitórias</th>
                <th>Derrotas</th>
                <th>Games Pró</th>
                <th>Games Contra</th>
                <th>Saldo</th>
                <th>Total de Pontos</th>
            </tr>

            <?php foreach ($ranking as $posicao => $jogador): ?>
                <tr>
                    <td><?= $posicao + 1 ?>º</td>
                    <td><?= htmlspecialchars($jogador["nome"]) ?></td>
                    <td><?= $jogador["jogos"] ?></td>
                    <td><?= $jogador["vitorias"] ?></td>
                    <td><?= $jogador["derrotas"] ?></td>
                    <td><?= $jogador["games_pro"] ?></td>
                    <td><?= $jogador["games_contra"] ?></td>
                    <td><?= $jogador["saldo"] ?></td>
                    <td><strong><?= $jogador["pontos"] ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <h2>Pontos por Rodada</h2>

    <div class="table-responsive">
        <table>
            <tr>
                <th>Jogador</th>
                <?php foreach ($evolucao as $linha): ?>
                    <th>R<?= $linha["rodada"] ?></th>
                <?php endforeach; ?>
            </tr>

            <?php foreach ($participantes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p["nome"]) ?></td>
                    <?php foreach ($evolucao as $linha): ?>
                        <td><?= $linha["jogadores"][$p["id"]]["pontos"] ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <p>Última atualização: <?= date("d/m/Y H:i") ?></p>

    <br>
    <a href="../rodadas/rodadas.php">
        <button>Voltar para Rodadas</button>
    </a>

    <br><br>
    <a href="../index.php">Voltar ao início</a>
</div>

</body>
</html>
