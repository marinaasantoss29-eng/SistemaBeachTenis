<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Super 8 - Beach Tennis</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>🏖️ Sistema Super 8 - Beach Tennis</h1>

    <p>Organize participantes, gere rodadas, lance placares e veja a classificação.</p>

    <div class="menu">
        <a href="configuracao/configuracao.php">1. Escolher Formato</a>
        <a href="participantes/cadastro.php">2. Cadastrar Participantes</a>
        <a href="rodadas/rodadas.php">3. Lançar Placares</a>
        <a href="classificacao/classificacao.php">4. Ver Classificação</a>
        <a href="reiniciar.php" onclick="return confirm('Tem certeza que deseja reiniciar o torneio?')">
            Reiniciar Torneio
        </a>
    </div>
</div>

</body>
</html>