<?php

require_once "./funciones.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  try {
    if(isset($_GET['addT'])) {
      $stmt = connect()->prepare("INSERT INTO transformadores(T_Codigo, T_Estado, T_Capacidad, T_Municipio, T_Direccion, T_Tipo, T_Banco) 
            VALUES(:codigo, :estado, :capacidad, :municipio, :direccion, :tipo, :banco)");

      $stmt->bindParam(':codigo', $codigo);
      $stmt->bindParam(':estado', $estado);
      $stmt->bindParam(':capacidad', $capacidad);
      $stmt->bindParam(':municipio', $municipio);
      $stmt->bindParam(':direccion', $direccion);
      $stmt->bindParam(':tipo', $tipo);
      $stmt->bindParam(':banco', $banco);

      $codigo = strClean($_POST["TCodigoAdd"]);
      $estado = strClean($_POST["TEstadoAdd"]);
      $capacidad = strClean($_POST["TCapacidadAdd"]);
      $municipio = strClean($_POST["TMunicipioAdd"]);
      $direccion = strClean($_POST["TDireccionAdd"]);
      $tipo = strClean($_POST["TTipoAdd"]);
      $banco = strClean($_POST["TBancoAdd"]);

      if($codigo == "" || $estado == "" || $capacidad == "" || $municipio == "" || $direccion == "" || $tipo == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }

      if($estado == "Almacenado" && $municipio != "Central de Servicios") {
        echo "<script>new swal('¡Error!', 'Los transformadores `Almacenados` solo pueden regitrarse en `Central de Servicios`', 'error');</script>";
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
    

    } else if(isset($_GET['updateT'])) {

      $sql = connect()->prepare("UPDATE transformadores SET T_Codigo = :codigo, T_Estado = :estado, T_Capacidad = :capacidad, T_Municipio = :municipio, T_Direccion = :direccion, T_Tipo = :tipo, T_Banco = :banco WHERE T_Codigo = :codigo");
      
      $sql->bindParam(":codigo", $codigo);
      $sql->bindParam(":estado", $estado);
      $sql->bindParam(":capacidad", $capacidad);
      $sql->bindParam(":municipio", $municipio);
      $sql->bindParam(":direccion", $direccion);
      $sql->bindParam(":tipo", $tipo);
      $sql->bindParam(":banco", $banco);

      $codigo = strClean($_POST["TCodigoUpdate"]);
      $estado = strClean($_POST["TEstadoUpdate"]);
      $capacidad = strClean($_POST["TCapacidadUpdate"]);
      $municipio = strClean($_POST["TMunicipioUpdate"]);
      $direccion = strClean($_POST["TDireccionUpdate"]);
      $tipo = strClean($_POST["TTipoUpdate"]);
      $banco = strClean($_POST["TBancoUpdate"]);

      if($estado == "" || $capacidad == "" || $municipio == "" || $direccion == "" || $tipo == "") {
        echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
        exit(); 
      }

      if($estado == "Almacenado" && $municipio != "Central de Servicios") {
        echo "<script>new swal('¡Error!', 'Los transformadores `Almacenados` solo pueden regitrarse en `Central de Servicios`', 'error');</script>";
        exit(); 
      }

      if($sql->execute()){
        echo "<script>new swal('¡Éxito!', 'Datos editados correctamente', 'success');</script>";
        echo '<script> window.location.href = "http://localhost/sistema-transformadores/inventario"; </script>';
      } else {
        echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
      }

    } else if(isset($_GET['deleteT'])) {
      $codigo = strClean($_POST["delT"]);

      $query = "DELETE FROM transformadores WHERE T_Codigo = '$codigo'";

      if(connect()->query($query)) {
        echo "<script>new swal('¡Éxito!', 'Transformador eliminado correctamente', 'success');</script>";
        echo '<script> window.location.href = "http://localhost/sistema-transformadores/inventario"; </script>';
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
