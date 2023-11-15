<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {
    if(isset($_POST['HAddInput'])) {
      $stmt = connect()->prepare("INSERT INTO operaciones(O_Codigo, O_Procedimiento, O_Fecha, O_Equipo, O_EstadoActual) 
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

      if($procedimiento == "" || $fecha == "" || $equipo == "" || $estado == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }

      $consulta = ejecutar_consulta_simple("SELECT T_Codigo FROM transformadores WHERE T_Codigo = '$equipo'");

      if($consulta->rowCount() <= 0) {
        echo "<script>new swal('¡Error!', 'El número serial ingresado no está registrado en el sistema', 'error');</script>";
        exit();
      } else {
        $consulta2 = connect()->query("SELECT * FROM transformadores WHERE T_Codigo = '$equipo'");

        while ($rows = $consulta2->fetch()) {
          $codigoT = $rows['T_Codigo'];
          $capacidadT = $rows['T_Capacidad'];
          $municipioT = $rows['T_Municipio'];
          $direccionT = $rows['T_Direccion'];
        };  

        $query = connect()->prepare("UPDATE transformadores SET T_Codigo = '$codigoT', T_Estado = '$estado', T_Capacidad = '$capacidadT', T_Municipio = '$municipioT', T_Direccion = '$direccionT' WHERE T_Codigo = '$equipo'");
      }

      $consulta4= ejecutar_consulta_simple("SELECT id FROM operaciones");
      $numero = ($consulta4->rowCount())+1;
      $codigo = generar_codigo_aleatorio("H", 7, $numero);

      if($stmt->execute()){
        $query->execute();
        echo "<script>new swal('¡Éxito!', 'Procedimiento registrado correctamente', 'success');</script>";
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
