<?php
    date_default_timezone_set("America/Caracas");

    session_start(['name' => 'Sistema']);

    if(!isset($_SESSION['token']) || !isset($_SESSION['usuario'])) {
        unset($_SESSION['id']);
        unset($_SESSION['codigo']);
        unset($_SESSION['usuario']);
        unset($_SESSION['clave']);
        unset($_SESSION['tipo']);
        unset($_SESSION['nombre']);
        unset($_SESSION['apellido']);
        unset($_SESSION['cargo']);
        unset($_SESSION['token']);
        unset($_SESSION['acceso']);

        session_regenerate_id(true);
                    
        session_destroy();
        header('Location: http://localhost/sistema-transformadores/login');
    
    }  else if(!isset($_GET['tipo'])) {
        header('Location: http://localhost/sistema-transformadores/reportes');
    }
        require_once "./funciones.php";
        require "../assets/extras/fpdf/fpdf.php";
                
        if($_GET['tipo'] == "general") {
            $query = connect()->query("SELECT * FROM municipios");

            $pdf = new FPDF("P", "mm", "A4");
            $pdf->AddPage();
            $pdf->SetTitle("Reporte de Transformadores");
            $pdf->Image("../assets/img/name.png", 10, 10, 45);
            $pdf->Image("../assets/img/rif.png", 170, 12, 25);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'República Bolivariana de Venezuela'), 0, 0, 'C');
            
            $pdf->Ln(6);
            $pdf->Cell(0, 10, 'Estado Sucre', 0, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Corporación Nacional Eléctrica'), 0, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Central de Servicios Carúpano'), 0, 0, 'C');
            $pdf->Ln(20);
                    
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Reporte General'), 0, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Transformadores instalados en la zona Carúpano-Paría'), 0, 2, 'C');
            $pdf->Ln(10);
            
            
            while ($rows = $query->fetch()) {
                $mun = $rows['M_Nombre'];
                $ult = $ult + 1;

                if($pdf->PageNo() != 1) {
                    $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Página ' . $pdf->PageNo() . ' - ' . munChoose($mun)), 0, 2, 'C');
                    $pdf->Ln(5);
                }

                $sql = connect()->prepare("SELECT * FROM transformadores WHERE T_Municipio = '$mun'");
                $sql->execute();
                $transData = $sql->fetch(PDO::FETCH_OBJ);

                $pdf->SetFont('Arial', 'B', 10);    
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', munChoose($mun)), 1, 1, 'C');
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(0, 7, iconv('UTF-8', 'ISO-8859-1', 'Transformadores Totales: ' . getMunCount(false, $mun)), 1, 1, 'C');
                
                if(munChoose($mun) == "Central de Servicios") {
                    $pdf->Cell(60, 7, iconv('UTF-8', 'ISO-8859-1', 'Transformadores Almacenados: ' . getMunCount('Almacenado', $mun)), 1, 0, 'C');
                } else {
                    $pdf->Cell(60, 7, iconv('UTF-8', 'ISO-8859-1', 'Transformadores Instalados: ' . getMunCount('Instalado', $mun)), 1, 0, 'C');
                }
 
                $pdf->Cell(60, 7, iconv('UTF-8', 'ISO-8859-1', 'Transformadores Dañados: ' . getMunCount('Dañado', $mun)), 1, 0, 'C');
                $pdf->Cell(70, 7, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada: ' . getMunCapacidad($mun)), 1, 1, 'C');
                                
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Información de los transformadores'), 1, 1, 'C');
                $pdf->SetFont('Arial', '', 9);

                $current_x = $pdf->GetX();
                
                $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(30, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
                $pdf->Cell(20, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado'), 1, 0, 'C');
                $pdf->Cell(35, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
                $pdf->Cell(43, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
                $pdf->Cell(19, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipo'), 1, 0, 'C');
                $pdf->Cell(33, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
                
                $num = 1;                
                $munTrans = connect()->query("SELECT * FROM transformadores WHERE T_Municipio = '$mun'");

                if($munTrans->rowCount() <= 0) {
                    $pdf->Cell(190, 9, 'Ninguno', 1, 1, 'C');
                } else {
                
                    while ($row = $munTrans->fetch()) {
                        $new_y = $pdf->GetY();
                        $pdf->SetTextColor(255);
                        $pdf->MultiCell(43, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
                        $pdf->SetTextColor(0);
                        $r_y = $pdf->GetY();

                        $div = intval(($r_y - $new_y ) / 9); 
                        $current_x = $pdf->GetX();
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(10, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 10;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(30, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Codigo']), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 30;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(20, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Estado']), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 20;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(35, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 35;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(43, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 43;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(19, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Tipo']), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                        $current_x = $current_x + 19;
                        $pdf->SetXY($current_x, $new_y);
                        $pdf->MultiCell(33, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                        $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                        $pdf->SetY($end_y);

                        $resta = intval($end_y - $new_y);
                        $div = intval($resta / 9);
                    }
                }

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones realizadas'), 1, 1, 'C');
                $pdf->SetFont('Arial', '', 9);

                $munOp = connect()->query("SELECT * FROM operaciones WHERE O_Municipio = '$mun'");
                $num2 = 1;

                $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(33, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimiento'), 1, 0, 'C');
                $pdf->Cell(28, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(43, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
                $pdf->Cell(39, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');

                if($munOp->rowCount() <= 0) {
                    $pdf->Cell(190, 9, 'Ninguno', 1, 1, 'C');
                } else {

                    while ($rows = $munOp->fetch()) {
                        $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', $num2++), 1, 0, 'C');
                        $pdf->Cell(33, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Procedimiento']), 1, 0, 'C');
                        $pdf->Cell(28, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(43, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Municipio']), 1, 0, 'C');
                        $pdf->Cell(39, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }

                $pdf->AddPage();

            }

            $pdf->Output();

        } else if($_GET['tipo'] == "personalizado") {
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                try {

                    $TCheck = strClean($_POST["TCheck"]);
                    $EstadoCheck = strClean($_POST["EstadoCheck"]);
                    $EstadoInput = strClean($_POST["EstadoInput"]);
                    $UbicacionCheck = strClean($_POST["UbicacionCheck"]);
                    $UbicacionInput = strClean($_POST["UbicacionInput"]);
                    $TipoCheck = strClean($_POST["TipoCheck"]);
                    $TipoInput = strClean($_POST["TipoInput"]);

                    $OCheck = strClean($_POST["OCheck"]);
                    $ProcCheck = strClean($_POST["ProcCheck"]);
                    $ProcInput = strClean($_POST["ProcInput"]);
                    $UbicacionProcCheck = strClean($_POST["UbicacionProcCheck"]);
                    $UbicacionProcInput = strClean($_POST["UbicacionProcInput"]);
                    $FechaCheck = strClean($_POST["FechaCheck"]);
                    $FechaInicio = strClean($_POST["FechaInicio"]);
                    $FechaFin = strClean($_POST["FechaFin"]);

                    if($TCheck != "on" && $OCheck != "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar una opción para generar el reporte', 'error');</script>";
                        exit(); 
                    }

                    if($TCheck == "on" && $OCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Solo puedes seleccionar un tema para generar el reporte', 'error');</script>";
                        exit(); 
                    }

                    if($TCheck != "on" && $EstadoCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($TCheck != "on" && $EstadoInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($TCheck != "on" && $UbicacionCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($TCheck != "on" &&  $UbicacionInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($TCheck != "on" && $TipoCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($TCheck != "on" && $TipoInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Transformadores` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    }


                    if($OCheck != "on" && $ProcCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($OCheck != "on" && $ProcInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit();
                    } else if($OCheck != "on" && $UbicacionProcCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($OCheck != "on" && $UbicacionProcInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($OCheck != "on" && $FechaCheck == "on") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($OCheck != "on" && $FechaInicio != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    } else if($OCheck != "on" && $FechaFin != "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar `Operaciones` para seleccionar sus opciones', 'error');</script>";
                        exit(); 
                    }


                    if($EstadoCheck != "on" && $EstadoInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Estado`', 'error');</script>";
                        exit(); 
                    } else if($EstadoCheck == "on" && $EstadoInput == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar un `Estado`', 'error');</script>";
                        exit(); 
                    } else if($EstadoCheck == "on" && $EstadoInput != "") {
                        $estado = $EstadoInput;
                    } else if($EstadoCheck != "on" && $EstadoInput == "") {
                        $estado = false;
                    }
                    
                    if($UbicacionCheck != "on" && $UbicacionInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Ubicación`', 'error');</script>";
                        exit(); 
                    } else if($UbicacionCheck == "on" && $UbicacionInput == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar una `Ubicación`', 'error');</script>";
                        exit(); 
                    } else if($UbicacionCheck == "on" && $UbicacionInput != "") {
                        $ubicacion = $UbicacionInput;
                    } else if($UbicacionCheck != "on" && $UbicacionInput == "") {
                        $ubicacion = false;
                    }
                    
                    if($TipoCheck != "on" && $TipoInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Tipo y Banco Transformador`', 'error');</script>";
                        exit(); 
                    } else if($TipoCheck == "on" && $TipoInput == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar un `Tipo`', 'error');</script>";
                        exit();
                    } else if($TipoCheck == "on" && $TipoInput != "") {
                        $tipo = $TipoInput;
                    } else if($TipoCheck != "on" && $TipoInput == "") {
                        $tipo = false;
                    }


                    if($ProcCheck != "on" && $ProcInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Procedimiento`', 'error');</script>";
                        exit(); 
                    } else if($ProcCheck == "on" && $ProcInput == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar un `Procedimiento`', 'error');</script>";
                        exit();
                    } else if($ProcCheck == "on" && $ProcInput != "") {
                        $procedimiento = $ProcInput;
                    } else if($ProcCheck != "on" && $ProcInput == "") {
                        $procedimiento = false;
                    }

                    if($UbicacionProcCheck != "on" && $UbicacionProcInput != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Ubicación del Procedimiento`', 'error');</script>";
                        exit(); 
                    } else if($UbicacionProcCheck == "on" && $UbicacionProcInput == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar una `Ubicación del Procedimiento`', 'error');</script>";
                        exit();
                    } else if($UbicacionProcCheck == "on" && $UbicacionProcInput != "") {
                        $ubicacionProc = $UbicacionProcInput;
                    } else if($UbicacionProcCheck != "on" && $UbicacionProcInput == "") {
                        $ubicacionProc = false;
                    }

                    if($FechaCheck != "on" && $FechaInicio != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Fecha`', 'error');</script>";
                        exit(); 
                    } else if($FechaCheck != "on" && $FechaFin != "") {
                        echo "<script>new swal('¡Error!', 'Debes activar la opción `Fecha`', 'error');</script>";
                        exit(); 
                    } else if($FechaCheck == "on" && $FechaInicio == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar una `Fecha` de Inicio', 'error');</script>";
                        exit();
                    } else if($FechaCheck == "on" && $FechaFin == "") {
                        echo "<script>new swal('¡Error!', 'Debes seleccionar una `Fecha` de Fin', 'error');</script>";
                        exit();
                    } else if($FechaCheck == "on" && $FechaInicio != "" && $FechaFin != "") {
                        $fechaI = $FechaInicio;
                        $fechaF = $FechaFin;
                    } else if($OCheck != "on") {
                        $fechaI = false;
                        $fechaF = false;
                    }

                    if($FechaInicio > $FechaFin) {
                        echo "<script>new swal('¡Error!', 'La fecha de Inicio no puede ser mayor que la fecha de Fin', 'error');</script>";
                        exit();
                    }

                    if($TCheck == "on" && $OCheck != "on") {
                        $titulo = "Reporte de Transformadores";
                    } else if($OCheck == "on" && $TCheck != "on") {
                        $titulo = "Reporte de Operaciones";
                    } else if($TCheck == "on" && $OCheck == "on") {
                        $titulo = "Reporte de Transformadores y Operaciones";
                    }

                    if($TCheck == "on" && $EstadoCheck != "on" && $UbicacionCheck != "on" && $TipoCheck != "on") {
                        $transformadores = true;
                    } else {
                        $transformadores = false;
                    }

                    if($OCheck == "on" && $ProcCheck != "on" && $UbicacionProcCheck != "on") {
                        $operaciones = true;
                    } else {
                        $operaciones = false;
                    }

        
                    echo '<script> window.open("http://localhost/sistema-transformadores/conexiones/report.php?titulo=' . $titulo . '&transformadores=' . $transformadores . '&estado=' . $estado . '&ubicac=' . $ubicacion . '&tipo=' . $tipo . '&operaciones=' . $operaciones . '&proc=' . $procedimiento . '&ubicproc=' . $ubicacionProc . '&fechaini=' . $fechaI . '&fechafin=' . $fechaF . '", "_blank"); </script>';
                    
                    

                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }


        }
    
    

?>
