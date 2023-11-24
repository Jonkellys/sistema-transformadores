<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {

    $codigo = $_GET['deleteT'];

    echo $codigo;
    
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

?>
