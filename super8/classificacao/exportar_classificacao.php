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

header("Content-Type: text/html; charset=UTF-8");
header("Content-Disposition: attachment; filename=classificacao-super8.html");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Classificação Super 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 32px; color: #10223d; }
        h1 { color: #0b7285; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cfd8dc; padding: 10px; text-align: center; }
        th { background: #0b7285; color: #fff; }
    </style>
</head>
<body>
    <h1>Classificação Final - Super 8 Beach Tennis</h1>
    <p>Exportado em <?= date("d/m/Y H:i") ?></p>

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
            <th>Pontos</th>
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
</body>
</html>
