<?php
require_once "../utils/json_helper.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Configuração do Torneio</title>
    <link rel="stylesheet" href="../css/style.css?v=2">
</head>
<body>

<div class="container tela-configuracao">
    <div class="config-header">
        <div class="icone-principal" aria-hidden="true">🏖️</div>
        <h1>Escolher Formato do Torneio</h1>
        <p class="texto-config">
            Selecione como as duplas serão organizadas antes de cadastrar os jogadores.
        </p>
    </div>

    <form action="../participantes/cadastro.php" method="GET">
        <div class="formatos-container">
            <label class="card-formato">
                <input type="radio" name="formato" value="rotativas" required>

                <div class="conteudo-formato">
                    <div class="icone-card" aria-hidden="true">🔁</div>

                    <h3>Duplas Rotativas</h3>

                    <p>As duplas serão sorteadas a cada rodada.</p>
                </div>
            </label>

            <label class="card-formato">
                <input type="radio" name="formato" value="fixas">

                <div class="conteudo-formato">
                    <div class="icone-card" aria-hidden="true">👥</div>

                    <h3>Duplas Fixas</h3>

                    <p>Os jogadores definem suas próprias duplas.</p>
                </div>
            </label>
        </div>

        <button type="submit" class="btn-continuar">
            Continuar
        </button>
    </form>

    <a href="../index.php" class="voltar">Voltar ao início</a>
</div>

</body>
</html>
