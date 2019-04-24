<?php
include("config.php");

$ds          = "/";
$storeFolder = 'uploads';
$position = $_GET['position'];
$id_vendeur = $_GET['id_vendeur'];
$id_stock = $_GET['id_stock'];
$dataURL = $_GET['dataURL'];

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
    $targetFile = $targetPath . $_FILES['file']['name'];
      $time = time();
      $sourcePath = $_FILES['file']['tmp_name'];
      $nom_fichier = $time.'-'.$_FILES['file']['name'];
      $targetPath = $storeFolder."/".$time.'-'.$_FILES['file']['name'];
      move_uploaded_file($sourcePath,$targetPath);
      $sql = "INSERT INTO `photos` (`id`, `id_stock`, `id_vendeur`, `position`, `url`, `dataURL`, `date_ajout`) VALUES (NULL, $id_stock, $id_vendeur, $position, '$nom_fichier', '$dataURL', CURRENT_TIMESTAMP);";
      echo $sql;
      $result = mysqli_query($link, $sql);
      // requete stockage
}
?>
