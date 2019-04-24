<?php
include("config.php");
$dataURL = $_GET['dataURL'];

// suppression uniquement des photos dans la base de données
// Pas touche aux photos uploadées sur le serveur
$sql = "DELETE FROM `photos` WHERE `photos`.`dataURL` = '$dataURL'";
echo $sql;
$result = mysqli_query($link, $sql);

?>
