<?php
    class mainModel {

        function conectar() {
            $servername = "localhost";
            $dbname = "sistema-asistencias";
            $username = "root";
            $password = "";
            
            $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        }

        static function ejecutar_consulta_simple($consulta) {
            $sql = conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }

        public static function encryption($string) {
            $output = FALSE;
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_encrypt($string, METHOD, $key, 0, 16);
            $output = base64_encode($output);
            return $output;
        }

        protected function decryption($string) {
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        static function generar_codigo_aleatorio($letra, $longitud, $num) {
            for ($i=1; $i <= $longitud ; $i++) { 
                $numero = rand(0, 9);
                $letra .= $numero;
            }

            return $letra . "-" . $num;
        }

        protected static function verificar_datos($filtro, $cadena) {
            if(preg_match("/^" . $filtro . "$/", $cadena)) {
                return false;
            } else {
                return true;
            }
        }

        function crearCuenta($codigo, $nombre, $apellido, $usuario, $clave, $email, $tipo, $genero) {
            $acou = self::conectar()->prepare("INSERT INTO cuentas(CuentaCodigo, CuentaNombre, CuentaApellido, CuentaUsuario, CuentaClave, CuentaEmail, CuentaTipo, CuentaGenero) 
                VALUES(:codigo, :nombre, :apellido, :usuario, :clave, :email, :tipo, :genero)");        
    
                $acou->bindParam(':codigo', $codigo);
                $acou->bindParam(':nombre', $nombre);
                $acou->bindParam(':apellido', $apellido);
                $acou->bindParam(':usuario', $usuario);
                $acou->bindParam(':clave', $clave);
                $acou->bindParam(':email', $email);
                $acou->bindParam(':tipo', $tipo);
                $acou->bindParam(':genero', $genero);
                $acou->execute();
                return $acou;
        }

        protected function eliminar_cuenta($codigo) {
            $sql = self::conectar()->prepare("DELETE FROM cuentas WHERE CuentaCodigo = :Codigo");
            $sql->bindParam(":Codigo", $codigo);
            $sql->execute();
            return $sql;
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

        protected function guardar_bitacora($datos) {
            $sql = conectar()->prepare("INSERT INTO bitacora(BitacoraCodigo, BitacoraFecha, BitacoraHoraInicio, BitacoraHoraFinal, BitacoraTipo, BitacoraYear, ) VALUES(:Codigo)");
        }

        protected function sweet_alert($datos) {
            if($datos['Alerta'] == "simple") {
                $alerta = "
                    <script>
                        new swal(
                            '".$datos['Titulo']."',
                            '".$datos['Texto']."',
                            '".$datos['Tipo']."',
                        );
                    </script>
                ";
            } elseif($datos['Alerta'] == "recargar") {
                $alerta = "
                    <script>
                        new swal({
                            title: '".$datos['Titulo']."',
                            text: '".$datos['Texto']."',
                            icon: '".$datos['Tipo']."',
                            confirmButtonText: 'Aceptar'
                        }) .then(function () {
                            location.reload();
                        });
                    </script>
                ";
            } elseif($datos['Alerta'] == "limpiar") {
                $alerta = "
                    <script>
                        new swal({
                            title: '".$datos['Titulo']."',
                            text: '".$datos['Texto']."',
                            icon: '".$datos['Tipo']."',
                            confirmButtonText: 'Aceptar'
                        }) .then(function () {
                            $('.FormularioAjax')[0].reset();
                        });
                    </script>
                ";
            } 
            return $alerta;
        }
    }
?>