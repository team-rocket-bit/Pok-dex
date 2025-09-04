<?php
$base = "https://pokeapi.co/api/v2/pokemon/";

$baseid = 1;
$data = file_get_contents($base.$id.'/');
$pokemon= json_decode($data);
echo $pokemon->name;

?>