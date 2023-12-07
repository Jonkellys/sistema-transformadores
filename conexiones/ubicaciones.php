<?php
  require_once "./funciones.php";

  $radMun = strClean($_POST['radMun']);

  if($radMun == "") {
    echo "<script>new swal('¡Error!', 'Debes seleccionar una opción', 'error');</script>";
    exit(); 
  }

  echo '<script> window.location.href = "http://localhost/sistema-transformadores/ubicaciones?municipio=' . $radMun .'"; </script>';

?>