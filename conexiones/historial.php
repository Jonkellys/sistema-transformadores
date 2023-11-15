<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {
      $stmt = connect()->prepare("INSERT INTO operaciones(O_Codigo, O_Procedimiento, O_Fecha, O_Equipo. O_EstadoActual) 
            VALUES(:codigo, :procedimiento, :fecha, :equipo, :estado)");

      $stmt->bindParam(':codigo', $codigo);
      $stmt->bindParam(':procedimiento', $procedimiento);
      $stmt->bindParam(':fecha', $fecha);
      $stmt->bindParam(':equipo', $equipo);
      $stmt->bindParam(':estado', $estado);

      $procedimiento = strClean($_POST["HProcAdd"]);
      $fecha = strClean($_POST["HFechaAdd"]);
      $equipo = strClean($_POST["HEquipoAdd"]);
      $estado = strClean($_POST["HEstadoAct"]);

      echo $procedimiento . " - " . $fecha . " - " . $equipo . " - " . $estado;

      // if($procedimiento == "" || $fecha == "" || $equipo == "" || $estado == "") {
      //   echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
      //   exit(); 
      // }

      // $consulta = ejecutar_consulta_simple("SELECT T_Codigo FROM transformadores WHERE T_Codigo = '$equipo'");

      // if($consulta->rowCount() <= 0) {
      //   echo "<script>new swal('¡Error!', 'El número serial ingresado no está registrado en el sistema', 'error');</script>";
      //   exit();
      // }

      // $consulta4= ejecutar_consulta_simple("SELECT id FROM operaciones");
      // $numero = ($consulta4->rowCount())+1;
      // $codigo = generar_codigo_aleatorio("H", 7, $numero);

      // if($stmt->execute()){
      //   echo "<script>new swal('¡Éxito!', 'Transformador registrado correctamente', 'success');</script>";
      // } else{
      //   echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      // }
    }

  
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

?>
