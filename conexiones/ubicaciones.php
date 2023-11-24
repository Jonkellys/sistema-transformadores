<?php
  require_once "./funciones.php";

  $radMun = strClean($_POST['radMun']);

  echo '<script> window.location.href = "http://localhost/sistema-transformadores/ubicaciones?municipio=' . $radMun .'"; </script>';

?>