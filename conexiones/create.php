<?php

    require_once "./funciones.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO usuarios(userCodigo, userUsername, userPassword, userType, userName, userLastname, userCargo, userEmail) 
            VALUES(:codigo, :usuario, :clave, :tipo, :nombre, :apellido, :cargo, :correo)");

            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':clave', $password);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':cargo', $cargo);
            $stmt->bindParam(':correo', $correo);
            
            $usuario = strClean($_POST["usuario"]);
            $clave = strClean($_POST["clave"]);
            $confirmar = strClean($_POST["confirmar"]);
            $password = password_hash($clave, PASSWORD_DEFAULT);

            $nombre = strClean($_POST["nombre"]);
            $apellido = strClean($_POST["apellido"]);
            $cargo = strClean($_POST["cargo"]);
            $correo = strClean($_POST["correo"]);
            $tipo = strClean($_POST["tipo"]);


            if($usuario == "" || $clave == "" || $confirmar == "" || $nombre == "" || $apellido == "" || $cargo == "" || $correo == "") { 
                echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
                exit(); 
            }

            if(strlen($clave) < 8){
                echo "<script>new swal('¡Error!', 'La contraseña debe tener mínimo 8 carácteres', 'error');</script>";
                exit();
            }
            
            if($clave != $confirmar){
                echo "<script>new swal('¡Error!', 'Las contraseñas no coinciden', 'error');</script>";
                exit();
            }  

            $consulta = ejecutar_consulta_simple("SELECT userEmail FROM usuarios WHERE userEmail = '$correo'");
                if($consulta->rowCount()>=1) {
                echo "<script>new swal('¡Error!', 'El correo ingresado ya está registrado en el sistema', 'error');</script>";
                    exit();
                }

            $consulta2 = ejecutar_consulta_simple("SELECT userUsername FROM usuarios WHERE userUsername = '$usuario'");
                if($consulta2->rowCount()>=1) {
                echo "<script>new swal('¡Error!', 'El usuario ingresado ya está registrado en el sistema', 'error');</script>";
                    exit();
                }
            
            $consulta4= ejecutar_consulta_simple("SELECT id FROM usuarios");
            $numero = ($consulta4->rowCount())+1;

            if ($tipo == "Administrador") {
            $codigo = generar_codigo_aleatorio("A", 7, $numero);
        } else {
                $codigo = generar_codigo_aleatorio("N", 7, $numero);

            }

            if($stmt->execute()){
                echo "<script>new swal('Cuenta Creada Correctamente', 'Inicie sesión para ingresar al sistema', 'success');</script>";
                echo '<script> window.location.href = "http://localhost/sistema-transformadores/login"; </script>';
            } else{
                echo "<script>new swal('Ocurrió un error', 'Por favor intente de nuevo', 'error');</script>";
            }
        } 
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }

?>
