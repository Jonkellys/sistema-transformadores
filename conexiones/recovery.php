<?php
    require_once "./funciones.php";

    if(isset($_GET['emailTrial'])) {

        $email = strClean($_POST['recoverForm']);

        if($email == "") {
            echo "<script>new swal('¡Error!', 'Debes colocar tu correo', 'error');</script>";
            exit(); 
        } else {
            $consulta = ejecutar_consulta_simple("SELECT userEmail FROM usuarios WHERE userEmail = '$email'");
            if($consulta->rowCount() != 1) {
                echo "<script>new swal('¡Error!', 'El correo ingresado no está registrado en el sistema', 'error');</script>";
                exit();
            }
        }

        $stmt = "SELECT * FROM usuarios WHERE userEmail = '$email'";
        $result = connect()->query($stmt);

        while ($rows = $result->fetch()) {
            $codigo = $rows['userCodigo'];
            $tipo = $rows['userType'];
        }; 

        $token = bin2hex(random_bytes(50));

        $sql = connect()->prepare("INSERT INTO contrasenas(contrasenaEmail, contrasenaToken, userCodigo, userType) VALUES ('$email', '$token', '$codigo', '$tipo')");

        if($sql->execute()){
            echo "<script>new swal('¡Éxito!', 'Espere un momento', 'success');</script>";
            echo '<script> window.location.href = "http://localhost/sistema-transformadores/newPass?token=' . $token .'"; </script>';
                
        } else {
            echo "<script>new swal('¡Error!', 'Hubo un error, intente de nuevo', 'error');</script>";
        }
    } else if(isset($_GET['newPass'])) {
        $token = strClean($_POST['token']);

        $pass = strClean($_POST['newPassForm']);
        $newpass = strClean($_POST['confirmPassForm']);
        $password = password_hash($pass, PASSWORD_DEFAULT);

        if($pass == "" || $newpass == "") {
            echo "<script>new swal('¡Error!', 'Debes llenar todos los campos', 'error');</script>";
            exit(); 
        }

        if(strlen($pass) < 8){
            echo "<script>new swal('¡Error!', 'La contraseña debe tener mínimo 8 carácteres', 'error');</script>";
            exit();
        }
        
        if($pass != $newpass){
            echo "<script>new swal('¡Error!', 'Las contraseñas no coinciden', 'error');</script>";
            exit();
        }  

        $stmt = "SELECT * FROM contrasenas WHERE contrasenaToken = '$token' LIMIT 1";
        $result = connect()->query($stmt);

        while ($rows = $result->fetch()) {
            $email = $rows['contrasenaEmail'];
            $tipo = $rows['userType'];
            $codigo = $rows['userCodigo'];
        }; 

        $sql = connect()->prepare("UPDATE usuarios SET userPassword = '$password'  WHERE userCodigo = '$codigo'");

        if($sql->execute()){
            echo "<script>new swal('Éxito!', 'Contraseña actualizada correctamente', 'success');</script>";
            echo '<script> window.location.href = "http://localhost/sistema-transformadores/login"; </script>';
        } else{
            echo "<script>new swal('¡Error!', 'Hubo un error intente de nuevo', 'error');</script>";
        }
    }
?>