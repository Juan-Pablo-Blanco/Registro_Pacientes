<?php
echo "<pre>";
//Base de datos
require_once 'config/config.php';
require_once 'model/db.php';
require_once 'model/paciente.php';
$db = new Db();
$conexion = $db->conection;




// Vistas
require_once 'view/templates/header.php';
echo $paciente->mostrarInformacion();   echo "<br>";
require_once 'view/templates/footer.php';
echo "</pre>";
?>
