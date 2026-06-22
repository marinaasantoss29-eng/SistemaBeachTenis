<?php
require_once "utils/json_helper.php";

gravar_json("data/participantes.json", []);
gravar_json("data/rodadas.json", []);

header("Location: index.php");
exit;
?><?php
require_once "utils/json_helper.php";

gravar_json("data/participantes.json", []);
gravar_json("data/rodadas.json", []);

echo "
<script>
alert('Torneio reiniciado com sucesso!');
window.location.href = 'index.php';
</script>
";
exit;
?>