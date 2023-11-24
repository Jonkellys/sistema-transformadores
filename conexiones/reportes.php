
<?php
    require_once "./funciones.php";
    require "../assets/extras/fpdf/fpdf.php";

    date_default_timezone_set("America/Caracas");
    
    if($_POST['tipo'] == "general") {
        $sql = connect()->prepare("SELECT * FROM transformadores");
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_OBJ);

        $pdf = new FPDF("P", "mm", "letter");
        $pdf->AddPage("Portrait");
        $pdf->SetTitle("Reporte de Asistencias");

        $pdf->Image("../assets/img/logo.png", 10, 5, 15);

        $pdf->Output();
    }
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $inicio = strClean($_POST['inicio']);
//     $fin = strClean($_POST['fin']);
//     $persona = strClean($_POST['persona']);

//     $fechaInicio = strtotime($inicio);
//     $fechaFin = strtotime($fin);
    
//     $sql = $conn->prepare("SELECT * FROM personal WHERE PersonalCodigo = '$persona'");
//     $sql->execute();
//     $data = $sql->fetch(PDO::FETCH_OBJ);

//     $mesI = date("m", $fechaInicio);
//     $mesF = date("m", $fechaFin);

//     if ($mesI == "01") {
//         $nombreMesI = "Enero";
//     } else if ($mesI == "02") {
//         $nombreMesI = "Febrero";
//     } else if($mesI == "03") {
//         $nombreMesI = "Marzo";
//     } else if ($mesI == "04") {
//         $nombreMesI = "Abril";
//     } else if ($mesI == "05") {
//         $nombreMesI = "Mayo";
//     } else if ($mesI == "06") {
//         $nombreMesI = "Junio";
//     } else if ($mesI == "07") {
//         $nombreMesI = "Julio";
//     } else if ($mesI == "08") {
//         $nombreMesI = "Agosto";
//     } else if ($mesI == "09") {
//         $nombreMesI = "Septiembre";
//     } else if ($mesI == "10") {
//         $nombreMesI = "Octubre";
//     } else if ($mesI == "11") {
//         $nombreMesI = "Noviembre";
//     } else if ($mesI == "12") {
//         $nombreMesI = "Diciembre";
//     }

//     if ($mesF == "01") {
//         $nombreMesF = "Enero";
//     } else if ($mesF == "02") {
//         $nombreMesF = "Febrero";
//     } else if($mesF == "03") {
//         $nombreMesF = "Marzo";
//     } else if ($mesF == "04") {
//         $nombreMesF = "Abril";
//     } else if ($mesF == "05") {
//         $nombreMesF = "Mayo";
//     } else if ($mesF == "06") {
//         $nombreMesF = "Junio";
//     } else if ($mesF == "07") {
//         $nombreMesF = "Julio";
//     } else if ($mesF == "08") {
//         $nombreMesF = "Agosto";
//     } else if ($mesF == "09") {
//         $nombreMesF = "Septiembre";
//     } else if ($mesF == "10") {
//         $nombreMesF = "Octubre";
//     } else if ($mesF == "11") {
//         $nombreMesF = "Noviembre";
//     } else if ($mesF == "12") {
//         $nombreMesF = "Diciembre";
//     }

//     require "../plantilla/assets/fpdf/fpdf.php";

//     $pdf = new FPDF("P", "mm", "letter");
//     $pdf->AddPage("Landscape");
//     $pdf->SetTitle(utf8_decode("Reporte de Asistencias"), false);

//     $pdf->Image("../plantilla/assets/img/logo1.png", 10, 5, 20);
//     $pdf->Cell(20);
//     $pdf->SetFont('Arial', '', 14);
//     $pdf->Write(10, utf8_decode('Sistema de Gestión de Asistencias v0.1'));
//     $pdf->SetFont('Arial', '', 10);

//     $pdf->Ln(18);
//     $pdf->Cell(5);
//     if ($persona == "Todos") {
//         $pdf->Write(10, "Personal: Todos");
//     } else {
//         $pdf->Write(10, "Personal: " . $data->PersonalNombre . " " . $data->PersonalApellido);
//     }
//     $pdf->Ln(5);
//     $pdf->Cell(5);
//     $pdf->Write(10, "Desde: " . date("d-m-Y", $fechaInicio) . " - Hasta: " . date("d-m-Y", $fechaFin));

//     $pdf->Ln(15);
//     $pdf->Cell(70);
//     $pdf->SetFont('Arial', 'B', 14);
//     $pdf->Write("10", utf8_decode('Reporte de Asistencias'));
//     $pdf->Ln(15);
     
    

//     $pdf->SetFont('Arial', 'B', 9);
//     $pdf->Cell(18);
//     $pdf->Cell(10, 9, utf8_decode('N'), 1);
//     $pdf->Cell(60, 9, utf8_decode('Nombre y Apellido'), 1);
//     $pdf->Cell(30, 9, utf8_decode('Cédula'), 1);
//     $pdf->Cell(30, 9, utf8_decode('Cargo'), 1);
//     $pdf->Cell(10, 9, utf8_decode('Día'), 1);
//     $pdf->Cell(25, 9, utf8_decode('Entrada'), 1);
//     $pdf->Cell(25, 9, utf8_decode('Salida'), 1);
//     $pdf->Cell(25, 9, utf8_decode('Horas Totales'), 1, 1);
    
//     $pdf->SetFont("Arial", "", 9);

// $hasta = date("Y-m-d", strtotime("+1 day", strtotime($fin))) . " 00:00:00";

//     if ($persona == "Todos") {
//         $buscar = "SELECT * FROM asistencias WHERE AsistenciaFecha BETWEEN '$inicio' AND '$hasta'";
//     } else {
//         $buscar = "SELECT * FROM asistencias WHERE PersonalCodigo = '$persona' AND AsistenciaFecha BETWEEN '$inicio' AND '$hasta'";
//     }
    
//     $resulta = $conn->query($buscar);
//     $num = 1;
    
//     while ($rows = $resulta->fetch()) {
//         $entradaF = strtotime($rows['AsistenciaFecha']);
//         $salidaF = strtotime($rows['AsistenciaSalida']);
//     $car = $rows['PersonalCodigo'];

//         $carDat = $conn->prepare("SELECT * FROM personal WHERE PersonalCodigo = '$car'");
//         $carDat->execute();
//         $cargo = $carDat->fetch(PDO::FETCH_OBJ);

//         $pdf->Cell(18);
//         $pdf->Cell(10, 9, $num++, 1);
//         $pdf->Cell(60, 9, utf8_decode($rows['AsistenciaNombre']), 1);
//         $pdf->Cell(30, 9, utf8_decode($rows['PersonalCedula']), 1);
//         $pdf->Cell(30, 9, utf8_decode($cargo->PersonalCargo), 1);
//         $pdf->Cell(10, 9, date("d",  $entradaF), 1);
//         $pdf->Cell(25, 9, date("h:i:s", $entradaF), 1);
//         $pdf->Cell(25, 9, date("h:i:s", $salidaF), 1);
//         $pdf->Cell(25, 9, date("h:i:s", $salidaF) - date("h:i:s", $entradaF), 1, 1);
//     }
        
//     $pdf->Output();
    

?>
