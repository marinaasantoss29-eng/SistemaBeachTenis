<?php
require_once "utils/json_helper.php";

gravar_json("data/participantes.json", []);
gravar_json("data/rodadas.json", []);

header("Location: index.php");
exit;
?>