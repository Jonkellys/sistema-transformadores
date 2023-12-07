<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {
    if(isset($_GET['HAdd'])) {
      $stmt = connect()->prepare("INSERT INTO operaciones(O_Codigo, O_Procedimiento, O_Fecha, O_Equipo, O_Municipio, O_EstadoActual) 
            VALUES(:codigo, :procedimiento, :fecha, :equipo, :municipio, :estado)");

      $stmt->bindParam(':codigo', $codigo);
      $stmt->bindParam(':procedimiento', $procedimiento);
      $stmt->bindParam(':fecha', $fecha);
      $stmt->bindParam(':equipo', $equipo);
      $stmt->bindParam(':municipio', $municipioT);
      $stmt->bindParam(':estado', $estado);

      $procedimiento = strClean($_POST["HProcAdd"]);
      $fecha = strClean($_POST["HFechaAdd"]);
      $equipo = strClean($_POST["HEquipoAdd"]);
   
      if($procedimiento == "" || $fecha == "" || $equipo == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }
      
      if($procedimiento == "Reparación") {
        $estado = "Almacenado";
      } else if($procedimiento == "Almacenamiento") {
        $estado = "Almacenado";
      } else if($procedimiento == "Instalación") {
        $estado = "Instalado";
      } else if($procedimiento == "Retiro") {
        $estado = "Dañado";
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
          $tipoT = $rows['T_Tipo'];
          $bancoT = $rows['T_Banco'];
          $estadoT = $rows['T_Estado'];
        };  

        if($estadoT == $estado) {
          echo "<script>new swal('¡Error!', 'El transformador ya se encuentra `" . $estadoT . "`<br> Seleccione otra opción', 'error');</script>";
          exit();
        }

        if($procedimiento == "Almacenamiento") {
	       $thing = "UPDATE transformadores SET T_Codigo = '$codigoT', T_Estado = '$estado', T_Capacidad = '$capacidadT', T_Municipio = 'Central de Servicios', T_Direccion = '$direccionT', T_Tipo = '$tipoT', T_Banco = '$bancoT' WHERE T_Codigo = '$equipo'";
        } else {
          $thing = "UPDATE transformadores SET T_Codigo = '$codigoT', T_Estado = '$estado', T_Capacidad = '$capacidadT', T_Municipio = '$municipioT', T_Direccion = '$direccionT', T_Tipo = '$tipoT', T_Banco = '$bancoT' WHERE T_Codigo = '$equipo'";	
        }

	     
	     $query = connect()->prepare($thing);
        
      }

      $consulta4= ejecutar_consulta_simple("SELECT id FROM operaciones");
      $numero = ($consulta4->rowCount())+1;
      $codigo = generar_codigo_aleatorio("H", 7, $numero);

      if($stmt->execute()){
        $query->execute();
        echo "<script>new swal('¡Éxito!', 'Procedimiento registrado correctamente', 'success');</script>";
        echo '<script> location.reload(); </script>';
      } else{
        echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      }
    } else if(isset($_GET['updateO'])) {
      $sql = connect()->prepare("UPDATE operaciones SET O_Codigo = :codigo, O_Procedimiento = :procedimiento, O_Fecha = :fecha, O_Equipo = :equipo, O_Municipio = :municipio, O_EstadoActual = :estado WHERE O_Codigo = :codigo");
      
      $sql->bindParam(":codigo", $codigo);
      $sql->bindParam(":procedimiento", $procedimiento);
      $sql->bindParam(":fecha", $fecha);
      $sql->bindParam(":equipo", $equipo);
      $sql->bindParam(":municipio", $municipio);
      $sql->bindParam(":estado", $estado);

      $codigo = strClean($_POST["HCodigoUpdate"]);
      $procedimiento = strClean($_POST["HProcUpdate"]);
      $fecha = strClean($_POST["HFechaUpdate"]);
      $equipo = strClean($_POST["HEquipoUpdate"]);
      $municipio = strClean($_POST["HMunicipioUpdate"]);
      $estado = strClean($_POST["HEstadoUpdate"]);

      if($procedimiento == "" || $fecha == "" || $equipo == "" || $estado == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }

      if($sql->execute()){
        echo "<script>new swal('¡Éxito!', 'Operación editada correctamente', 'success');</script>";
        echo '<script> window.location.href = "http://localhost/sistema-transformadores/historial"; </script>';
      } else{
        echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      }

    } else if(isset($_GET['deleteO'])) {
      $codigo = strClean($_POST["delO"]);

      $query = "DELETE FROM operaciones WHERE O_Codigo = '$codigo'";

      if(connect()->query($query)) {
        echo "<script>new swal('¡Éxito!', 'Operación eliminada correctamente', 'success');</script>";
        echo '<script> window.location.href = "http://localhost/sistema-transformadores/historial"; </script>';
      } else {
        echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      }
    }
  } 
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

?>
