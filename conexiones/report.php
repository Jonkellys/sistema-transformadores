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
    
    }

    require_once "./funciones.php";
    
    require "../assets/extras/fpdf/fpdf.php";

    $titulo = strClean($_GET['titulo']);
    $transformadores = strClean($_GET['transformadores']);
    $estado = strClean($_GET['estado']);
    $capacidad = strClean($_GET['capac']);
    $ubicacion = strClean($_GET['ubicac']);
    $tipo = strClean($_GET['tipo']);
    $operaciones = strClean($_GET['operaciones']);
    $procedimiento = strClean($_GET['proc']);
    $ubicproc = strClean($_GET['ubicproc']);
    $fechaini = strClean($_GET['fechaini']);
    $fechafin = strClean($_GET['fechafin']);

    $pdf = new FPDF("L", "mm", "A4");
    $pdf->AddPage();
    $pdf->SetTitle("Reporte de Transformadores");
    $pdf->Image("../assets/img/name.png", 10, 10, 65);
    $pdf->Image("../assets/img/rif.png", 245, 12, 35);
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
    $pdf->Cell(0, 10, $titulo, 0, 0, 'C');
    $pdf->Ln(20);
    
    if($transformadores == true || $estado == "Todos" || $ubicacion == "Todos" || $tipo == "Todos") {

        if($estado == "Todos") {
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Estados: Todos'), 0, 1, 'C');
        } 
        if($ubicacion == "Todos") {
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicaciones: Todos'), 0, 1, 'C');
        }
        if($tipo == "Todos") {
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipos: Todos'), 0, 1, 'C');
        }

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
        $pdf->Cell(30, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
        $pdf->Cell(22, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado'), 1, 0, 'C');
        $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
        $pdf->Cell(43, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
        $pdf->Cell(75, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
        $pdf->Cell(19, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipo'), 1, 0, 'C');
        $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
        
        $num = 1;        
        $pdf->SetFont('Arial', '', 9);
        $munTrans = connect()->query("SELECT * FROM transformadores");

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
                $pdf->MultiCell(22, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Estado']), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                $current_x = $current_x + 22;
                $pdf->SetXY($current_x, $new_y);
                $pdf->MultiCell(37, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                $current_x = $current_x + 37;
                $pdf->SetXY($current_x, $new_y);
                $pdf->MultiCell(43, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Municipio']), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                $current_x = $current_x + 43;
                $pdf->SetXY($current_x, $new_y);
                $pdf->MultiCell(75, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                $current_x = $current_x + 75;
                $pdf->SetXY($current_x, $new_y);
                $pdf->MultiCell(19, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Tipo']), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                $current_x = $current_x + 19;
                $pdf->SetXY($current_x, $new_y);
                $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                $pdf->SetY($end_y);

                $resta = intval($end_y - $new_y);
                $div = intval($resta / 9);
            }
        }
    } else if($transformadores == false) {
        if($estado != false && $estado != "Todos" && $tipo == false && $ubicacion == false) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores en Estado: ' . $estado), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(30, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(43, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
            $pdf->Cell(97, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(19, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipo'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $pdf->SetFont('Arial', '', 9);
            $estFetch = connect()->query("SELECT * FROM transformadores WHERE T_Estado = '$estado'");

            if($estFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $estFetch->fetch()) {
                    $new_y = $pdf->GetY();
                    $pdf->SetTextColor(255);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
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
                    $pdf->MultiCell(37, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 37;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(43, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Municipio']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 43;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 97;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(19, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Tipo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 19;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }

        if($estado != false && $estado != "Todos" && $ubicacion != false && $ubicacion != "Todos") {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores en Estado: ' . $estado . ' - Ubicados en: ' . munChoose($ubicacion)), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(40, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(47, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(32, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipo'), 1, 0, 'C');
            $pdf->Cell(97, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $pdf->SetFont('Arial', '', 9);
            $tipoFetch = connect()->query("SELECT * FROM transformadores WHERE T_Estado = '$estado' AND T_Municipio = '$ubicacion'");

            if($tipoFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $tipoFetch->fetch()) {
                    $new_y = $pdf->GetY();
                    $pdf->SetTextColor(255);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
                    $pdf->SetTextColor(0);
                    $r_y = $pdf->GetY();
    
                    $div = intval(($r_y - $new_y ) / 9); 
                    $current_x = $pdf->GetX();
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(20, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 20;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(40, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Codigo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
        
                    $current_x = $current_x + 40;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(47, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 47;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(32, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Tipo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 32;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

    
                    $current_x = $current_x + 97;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }

        if($estado != false && $estado != "Todos" && $tipo != false && $tipo != "Todos") {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores en Estado: ' . $estado . ' - De tipo: ' . $tipo), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(52, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(57, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(107, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $pdf->SetFont('Arial', '', 9);
            $tipoFetch = connect()->query("SELECT * FROM transformadores WHERE T_Estado = '$estado' AND T_Tipo = '$tipo'");

            if($tipoFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $tipoFetch->fetch()) {
                    $new_y = $pdf->GetY();
                    $pdf->SetTextColor(255);
                    $pdf->MultiCell(107, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
                    $pdf->SetTextColor(0);
                    $r_y = $pdf->GetY();
    
                    $div = intval(($r_y - $new_y ) / 9); 
                    $current_x = $pdf->GetX();
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(20, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 20;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(52, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Codigo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
        
                    $current_x = $current_x + 52;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(57, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 57;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(107, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

    
                    $current_x = $current_x + 107;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }

        if($ubicacion != false && $ubicacion != "Todos" && $estado == false && $tipo == false) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores Ubicados en: ' . munChoose($ubicacion)), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(30, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(40, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado'), 1, 0, 'C');
            $pdf->Cell(97, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(22, 9, iconv('UTF-8', 'ISO-8859-1', 'Tipo'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $pdf->SetFont('Arial', '', 9);
            $ubicFetch = connect()->query("SELECT * FROM transformadores WHERE T_Municipio = '$ubicacion'");

            if($ubicFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $ubicFetch->fetch()) {
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
                    $pdf->MultiCell(37, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 37;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(40, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Estado']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 40;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 97;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(22, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Tipo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 22;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }

        if($tipo != false && $tipo != "Todos" && $ubicacion == false && $estado == false) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores de tipo: ' . $tipo), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(10, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(30, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(37, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(22, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado'), 1, 0, 'C');
            $pdf->Cell(40, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
            $pdf->Cell(97, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $pdf->SetFont('Arial', '', 9);
            $tipoFetch = connect()->query("SELECT * FROM transformadores WHERE T_Tipo = '$tipo'");

            if($tipoFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $tipoFetch->fetch()) {
                    $new_y = $pdf->GetY();
                    $pdf->SetTextColor(255);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
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
                    $pdf->MultiCell(37, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 37;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(22, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Estado']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 22;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(40, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Municipio']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 40;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

    
                    $current_x = $current_x + 97;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }


        if($tipo != false && $tipo != "Todos" && $ubicacion != false && $ubicacion != "Todos") {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Transformadores de tipo: ' . $tipo . ' - Ubicados en: ' . munChoose($ubicacion)), 0, 1, "C");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(20, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(40, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial'), 1, 0, 'C');
            $pdf->Cell(47, 9, iconv('UTF-8', 'ISO-8859-1', 'Capacidad Instalada'), 1, 0, 'C');
            $pdf->Cell(32, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado'), 1, 0, 'C');
            $pdf->Cell(97, 9, iconv('UTF-8', 'ISO-8859-1', 'Dirección'), 1, 0, 'C');
            $pdf->Cell(38, 9, iconv('UTF-8', 'ISO-8859-1', 'Banco Transformador'), 1, 1, 'C');
            
            $num = 1;        
            $tipoFetch = connect()->query("SELECT * FROM transformadores WHERE T_Tipo = '$tipo' AND T_Municipio = '$ubicacion'");
            $pdf->SetFont('Arial', '', 9);

            if($tipoFetch->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {
                while ($row = $tipoFetch->fetch()) {
                    $new_y = $pdf->GetY();
                    $pdf->SetTextColor(255);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 0, 'C');
                    $pdf->SetTextColor(0);
                    $r_y = $pdf->GetY();
    
                    $div = intval(($r_y - $new_y ) / 9); 
                    $current_x = $pdf->GetX();
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(20, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 20;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(40, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Codigo']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
        
                    $current_x = $current_x + 40;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(47, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Capacidad'] . " w"), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
    
                    $current_x = $current_x + 47;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(32, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Estado']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

                    $current_x = $current_x + 32;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(97, 9, iconv('UTF-8', 'ISO-8859-1', $row['T_Direccion']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;

    
                    $current_x = $current_x + 97;
                    $pdf->SetXY($current_x, $new_y);
                    $pdf->MultiCell(38, 9 * $div, iconv('UTF-8', 'ISO-8859-1', $row['T_Banco']), 1, 'C');
                    $end_y = ($pdf->GetY() > $end_y)?$pdf->GetY() : $end_y;
                    $pdf->SetY($end_y);
    
                    $resta = intval($end_y - $new_y);
                    $div = intval($resta / 9);
                }
            }
        }
    }



    if($operaciones == true || $procedimiento == "Todos" || $ubicproc == "Todos") {
        $num2 = 1;

        if($procedimiento == "Todos") {
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimientos: Todos'), 0, 1, 'C');
        } else if($ubicproc == "Todos") {
            $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicaciones: Todos'), 0, 1, 'C');
        }
        
        if($fechaini == false && $fechafin == false) {
            $mainOp = connect()->query("SELECT * FROM operaciones");

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimiento'), 1, 0, 'C');
            $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
            $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
            $pdf->Cell(50, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
            $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');

            $pdf->SetFont('Arial', '', 9);

            if($mainOp->rowCount() <= 0) {
                $pdf->Cell(274, 9, 'Ninguno', 1, 1, 'C');
            } else {

                while ($rows = $mainOp->fetch()) {
                    $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num2++), 1, 0, 'C');
                    $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Procedimiento']), 1, 0, 'C');
                    $pdf->Cell(45, 9, $rows['O_Fecha'], 1, 0, 'C');
                    $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                    $pdf->Cell(50, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Municipio']), 1, 0, 'C');
                    $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                }
            }
        } else if($fechaini != false && $fechafin != false) {
            $mainOp = connect()->query("SELECT * FROM operaciones WHERE O_Fecha > '$fechaini' AND O_Fecha < '$fechafin'");

            $pdf->Cell(0, 9, 'Reporte de Operaciones desde ' . $fechaini . ' hasta ' . $fechafin, 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
            $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimiento'), 1, 0, 'C');
            $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
            $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
            $pdf->Cell(50, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
            $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');

            $pdf->SetFont('Arial', '', 9);

            if($mainOp->rowCount() <= 0) {
                $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
            } else {

                while ($rows = $mainOp->fetch()) {
                    $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num2++), 1, 0, 'C');
                    $pdf->Cell(45, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Procedimiento']), 1, 0, 'C');
                    $pdf->Cell(45, 9, $rows['O_Fecha'], 1, 0, 'C');
                    $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                    $pdf->Cell(50, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Municipio']), 1, 0, 'C');
                    $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                }
            }
        }

    } else if($operaciones == false) {
        if($ubicproc != false && $ubicproc != "Todos" && $procedimiento != false && $procedimiento != "Todos") {
            $num = 1;   

            if($fechaini == false && $fechafin == false) {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones de procedimiento: ' . $procedimiento . ' - Realizadas en: ' . munChoose($ubicproc)), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(25, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);

                $ubiOp = connect()->query("SELECT * FROM operaciones WHERE O_Municipio = '$ubicproc' && O_Procedimiento = '$procedimiento'");
           
                if($ubiOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
                    while ($rows = $ubiOp->fetch()) {
                        $pdf->Cell(25, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(70, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }
                
            } else {   
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones de procedimiento: ' . $procedimiento . ' - Realizadas en: ' . munChoose($ubicproc) . ' - Desde ' . $fechaini . ' hasta ' . $fechafin), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(25, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);
                $ubiOp = connect()->query("SELECT * FROM operaciones WHERE O_Municipio = '$ubicproc' AND O_Procedimiento = '$procedimiento' AND O_Fecha > '$fechaini' AND O_Fecha < '$fechafin'");
           
                if($ubiOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
        
                    while ($rows = $ubiOp->fetch()) {
                        $pdf->Cell(25, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(70, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(90, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }
            }
        }

        if($procedimiento != false && $procedimiento != "Todos" && $ubicproc == false) {
            $num = 1;   

            if($fechaini == false && $fechafin == false) {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones de procedimiento: ' . $procedimiento), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);

                $procOp = connect()->query("SELECT * FROM operaciones WHERE O_Procedimiento = '$procedimiento'");
           
                if($procOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
                    while ($rows = $procOp->fetch()) {
                        $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(60, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Municipio']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }

            } else {   
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones de procedimiento: ' . $procedimiento  . ' - desde ' . $fechaini . ' hasta ' . $fechafin), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Ubicación'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);
                $procOp = connect()->query("SELECT * FROM operaciones WHERE O_Procedimiento = '$procedimiento' AND O_Fecha > '$fechaini' AND O_Fecha < '$fechafin'");
           
                if($procOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
        
                    while ($rows = $procOp->fetch()) {
                        $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(60, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Municipio']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }
            }
        }

        if($ubicproc != false && $ubicproc != "Todos" && $procedimiento == false) {
            $num = 1;   

            if($fechaini == false && $fechafin == false) {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones realizadas en: ' . $ubicproc), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimiento'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);

                $ubiOp = connect()->query("SELECT * FROM operaciones WHERE O_Municipio = '$ubicproc'");
           
                if($ubiOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
                    while ($rows = $ubiOp->fetch()) {
                        $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(60, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Procedimiento']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }
                
            } else {   
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 9, iconv('UTF-8', 'ISO-8859-1', 'Operaciones realizadas en: ' . $ubicproc  . ' - desde ' . $fechaini . ' hasta ' . $fechafin), 0, 1, "C");

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', '#'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Fecha'), 1, 0, 'C');
                $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', 'Procedimiento'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'N° Serial del Transformador'), 1, 0, 'C');
                $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', 'Estado del Transformador'), 1, 1, 'C');
                
                $pdf->SetFont('Arial', '', 9);
                $ubiOp = connect()->query("SELECT * FROM operaciones WHERE O_Municipio = '$ubicproc' AND O_Fecha > '$fechaini' AND O_Fecha < '$fechafin'");
           
                if($ubiOp->rowCount() <= 0) {
                    $pdf->Cell(275, 9, 'Ninguno', 1, 1, 'C');
                } else {
        
                    while ($rows = $ubiOp->fetch()) {
                        $pdf->Cell(15, 9, iconv('UTF-8', 'ISO-8859-1', $num++), 1, 0, 'C');
                        $pdf->Cell(60, 9, $rows['O_Fecha'], 1, 0, 'C');
                        $pdf->Cell(60, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Procedimiento']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_Equipo']), 1, 0, 'C');
                        $pdf->Cell(70, 9, iconv('UTF-8', 'ISO-8859-1', $rows['O_EstadoActual']), 1, 1, 'C');
                    }
                }
            }
        }
        
    }

    $pdf->Output();
?>