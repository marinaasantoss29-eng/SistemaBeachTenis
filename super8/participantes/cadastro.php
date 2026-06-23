<?php
require_once "../utils/json_helper.php";

$participantes = ler_json("../data/participantes.json");
$formato = $_GET["formato"] ?? "";
$urlGerarRodadas = "../configuracao/gerar_rodadas.php";

if ($formato != "") {
    $urlGerarRodadas .= "?formato=" . urlencode($formato);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Participantes</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h1>Cadastro de Participantes</h1>

    <?php if (count($participantes) >= 8): ?>
        <div class="card">
            <strong>Os 8 participantes já foram cadastrados.</strong>
        </div>

        <h2>Participantes cadastrados:</h2>

        <ul>
            <?php foreach ($participantes as $p): ?>
                <li>
                    <?= htmlspecialchars($p["nome"]) ?>
                    <?php if (!empty($p["apelido"])): ?>
                        - <?= htmlspecialchars($p["apelido"]) ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="<?= htmlspecialchars($urlGerarRodadas) ?>">
            <button>Próximo: Gerar Rodadas</button>
        </a>

    <?php else: ?>

        <form action="salvar_participantes.php" method="POST">
            <input type="hidden" name="formato" value="<?= htmlspecialchars($formato) ?>">

            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="card">
                    <h3>Participante <?= $i ?></h3>

                    <label>Nome completo:</label>
                    <input type="text" name="nome[]" required>

                    <label>Apelido opcional:</label>
                    <input type="text" name="apelido[]">
                </div>
            <?php endfor; ?>

            <button type="submit">Salvar Participantes</button>
        </form>

    <?php endif; ?>

    <br><br>
    <a href="../index.php">
    <button>Voltar ao início</button>
</a>
</div>

</body>
</html>
