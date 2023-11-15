<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {
    if(isset($_POST['TAddInput'])) {
      $stmt = connect()->prepare("INSERT INTO transformadores(T_Codigo, T_Estado, T_Capacidad, T_Municipio, T_Direccion) 
            VALUES(:codigo, :estado, :capacidad, :municipio, :direccion)");

      $stmt->bindParam(':codigo', $codigo);
      $stmt->bindParam(':estado', $estado);
      $stmt->bindParam(':capacidad', $capacidad);
      $stmt->bindParam(':municipio', $municipio);
      $stmt->bindParam(':direccion', $direccion);

      $codigo = strClean($_POST["TCodigoAdd"]);
      $estado = strClean($_POST["TEstadoAdd"]);
      $capacidad = strClean($_POST["TCapacidadAdd"]);
      $municipio = strClean($_POST["TMunicipioAdd"]);
      $direccion = strClean($_POST["TDireccionAdd"]);

      if($codigo == "" || $estado == "" || $capacidad == "" || $municipio == "" || $direccion == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }

      $consulta = ejecutar_consulta_simple("SELECT T_Codigo FROM transformadores WHERE T_Codigo = '$codigo'");

      if($consulta->rowCount()>=1) {
        echo "<script>new swal('¡Error!', 'El número serial ingresado ya está registrado en el sistema', 'error');</script>";
        exit();
      }

      if($stmt->execute()){
        echo "<script>new swal('¡Éxito!', 'Transformador registrado correctamente', 'success');</script>";
        echo '<script> location.reload(); </script>';
      } else{
        echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      }
    }

  } 
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

?>
