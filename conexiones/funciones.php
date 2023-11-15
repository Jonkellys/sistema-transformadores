<?php

    $servername = "localhost";
    $dbname = "sistema-corpoelec";
    $username = "root";
    $password = "";

    function connect() {
        $servername = "localhost";
        $dbname = "sistema-corpoelec";
        $username = "root";
        $password = "";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    }

    function funcData() {
        $benitezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Benítez' AND T_Estado = 'Funcionando'");
        $benitezTotal = $benitezData->rowCount(); 

        $bermudezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Bermúdez' AND T_Estado = 'Funcionando'");
        $bermudezTotal = $bermudezData->rowCount(); 

        $cajigalData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Cajigal' AND T_Estado = 'Funcionando'");
        $cajigalTotal = $cajigalData->rowCount(); 

        $libertadorData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Libertador' AND T_Estado = 'Funcionando'");
        $libertadorTotal = $libertadorData->rowCount(); 

        $mariñoData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Mariño' AND T_Estado = 'Funcionando'");
        $mariñoTotal = $mariñoData->rowCount(); 

        $valdezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Valdez' AND T_Estado = 'Funcionando'");
        $valdezTotal = $valdezData->rowCount(); 

        $mainData = [$benitezTotal, $bermudezTotal, $cajigalTotal, $libertadorTotal, $mariñoTotal, $valdezTotal];
        return $mainData;
    }

    function damData() {
        $benitezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Benítez' AND T_Estado = 'Dañado'");
        $benitezTotal = $benitezData->rowCount(); 

        $bermudezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Bermúdez' AND T_Estado = 'Dañado'");
        $bermudezTotal = $bermudezData->rowCount(); 

        $cajigalData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Cajigal' AND T_Estado = 'Dañado'");
        $cajigalTotal = $cajigalData->rowCount(); 

        $libertadorData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Libertador' AND T_Estado = 'Dañado'");
        $libertadorTotal = $libertadorData->rowCount(); 

        $mariñoData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Mariño' AND T_Estado = 'Dañado'");
        $mariñoTotal = $mariñoData->rowCount(); 

        $valdezData = connect()->query("SELECT id FROM transformadores WHERE T_Municipio = 'Valdez' AND T_Estado = 'Dañado'");
        $valdezTotal = $valdezData->rowCount(); 

        $mainData = [$benitezTotal, $bermudezTotal, $cajigalTotal, $libertadorTotal, $mariñoTotal, $valdezTotal];
        return $mainData;
    }

    function strClean($strCadena) {
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
        $string = trim($string);
        $string = stripslashes($string);
        $string = str_ireplace("<script>", "", $string);
        $string = str_ireplace("</script>", "", $string);
        $string = str_ireplace("<script src>", "", $string);
        $string = str_ireplace("<script type=>", "", $string);
        $string = str_ireplace("SELECT * FROM", "", $string);
        $string = str_ireplace("DELETE FROM", "", $string);
        $string = str_ireplace("INSERT INTO", "", $string);
        $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
        $string = str_ireplace("DROP TABLE", "", $string);
        $string = str_ireplace("OR '1'='1'", "", $string);
        $string = str_ireplace('OR "1"="1"', "", $string);
        $string = str_ireplace('OR ’1’=’1’', "", $string);
        $string = str_ireplace("is NULL; --", "", $string);
        $string = str_ireplace("is NULL; --", "", $string);
        $string = str_ireplace("LIKE '", "", $string);
        $string = str_ireplace('LIKE "', "", $string);
        $string = str_ireplace("LIKE ’", "", $string);
        $string = str_ireplace("OR 'a'='a", "", $string);
        $string = str_ireplace('OR "a"="a', "", $string);
        $string = str_ireplace("OR ’a’=’a", "", $string);
        $string = str_ireplace("__", "", $string);
        $string = str_ireplace("^", "", $string);
        $string = str_ireplace("[", "", $string);
        $string = str_ireplace("]", "", $string);
        $string = str_ireplace("==", "", $string);

        return $string;
    }

    function conectar() {
        $servername = "localhost";
        $dbname = "sistema-corpoelec";
        $username = "root";
        $password = "";
        
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    }

    function encrypt($string) {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 4);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    function decrypt($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 4);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    function ejecutar_consulta_simple($consulta) {
        $consul = conectar()->prepare($consulta);
        $consul->execute();
        return $consul;
    }

    function generar_codigo_aleatorio($letra, $longitud, $num) {
        for ($i=1; $i <= $longitud ; $i++) { 
            $numero = rand(0, 9);
            $letra .= $numero;
        }

        return $letra . "-" . $num;
    }

    function updateCuenta($nombre, $apellido, $usuario, $correo, $genero, $codigo) {
        $upCuenta = conectar()->prepare("UPDATE cuentas SET CuentaNombre = '$nombre', CuentaEmail = '$correo', CuentaApellido = '$apellido', CuentaUsuario = '$usuario', CuentaGenero = '$genero' WHERE CuentaCodigo = '$codigo'");
        $upCuenta->execute();
        return $upCuenta;
    } 

    function updatePass($pass, $codigo) {
        $upPass = conectar()->prepare("UPDATE cuentas SET CuentaClave = '$pass' WHERE CuentaCodigo = '$codigo'");
        $upPass->execute();
        return $upPass;
    }

    function eliminarCuenta($codigo) {
        $delCuenta = "DELETE FROM cuentas WHERE CuentaCodigo = '$codigo'";
        $delCuenta = conectar()->query($delCuenta);
        return $delCuenta;
    }

    function eliminarAdmin($codigo) {
        $sql = conectar()->prepare("DELETE FROM admins WHERE CuentaCodigo = :codigo");
        $sql->bindParam(":codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    function eliminarUsuario($codigo) {
        $query = conectar()->prepare("DELETE FROM Usuarios WHERE CuentaCodigo = :codigo");
        $query->bindParam(":codigo", $codigo);
        $query->execute();
        return $query;
    }

    function iniciarSesion($usuario) {
        $servername = "localhost";
        $dbname = "sistema-corpoelec";
        $username = "root";
        $password = "";
        
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $con->prepare("SELECT * FROM usuarios WHERE userUsername = :usuario");
        $sql->bindParam(":usuario", $usuario);
        $sql->execute();
        return $sql;
    }
?>
