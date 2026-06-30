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
$campeao = $ranking[0];
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
        <h2>
    🏆 <?= ($rodadas[0]["formato"] ?? "") == "fixas" ? "Dupla Campeã" : "Líder da Classificação" ?>
</h2>
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

    <div class="acoes-classificacao">
        <button type="button" data-imprimir-pagina>Imprimir Classificação</button>
    </div>

    <div class="table-responsive">
        <table>
            <tr>
                <th>Posição</th>
                <th><?= ($rodadas[0]["formato"] ?? "") == "fixas" ? "Dupla" : "Jogador" ?></th>
                <th>Total de Pontos</th>
                <th>Partidas</th>
                <th>Vitórias</th>
                <th>Derrotas</th>
                <th>Games Pró</th>
                <th>Games Contra</th>
                <th>Saldo</th>
            </tr>

            <?php foreach ($ranking as $posicao => $jogador): ?>
                <tr>
                    <td><?= $posicao + 1 ?>º</td>
                    <td><?= htmlspecialchars($jogador["nome"]) ?></td>
                    <td><strong><?= $jogador["pontos"] ?></strong></td>
                    <td><?= $jogador["jogos"] ?></td>
                    <td><?= $jogador["vitorias"] ?></td>
                    <td><?= $jogador["derrotas"] ?></td>
                    <td><?= $jogador["games_pro"] ?></td>
                    <td><?= $jogador["games_contra"] ?></td>
                    <td><?= $jogador["saldo"] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    

    <br>

    <a href="../rodadas/rodadas.php">
        <button>Voltar para Rodadas</button>
    </a>

    <br><br>

    <a href="../index.php">
        <button>Voltar ao início</button>
    </a>
</div>

<script src="../js/ui.js"></script>

</body>
</html>