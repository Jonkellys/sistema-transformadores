<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

  $page = "reportes";

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Reportes | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5">
    <h4 class="fw-bold mb-0">Reportes</h4>
  </div>

  <div class="container-fluid p-4">

    <div class="col-lg-10 mx-auto card">
      <div class="card-body">
        <h4 class="card-title">Seleccione una Opción</h4>
        <div id="accordion-one" class="accordion">
          <div class="d-flex flex-row justify-content-space">

            <form action="<?php echo SERVERURL; ?>conexiones/reportes.php" name="RGeneral" id="RGeneral" autocomplete="off" enctype="multipart/form-data" method="POST" >
              <input type="hidden" name="tipo" value="general">
              <button type="submit" class="mb-0 btn btn-primary mx-1">Reporte General</button>
            </form>

            <!-- <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-plus-circle"></i> Añadir Transformador</button>
            <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne"></button> -->
          </div>
          <!-- <div id="collapseOne" class="collapse card mt-3 col-9 rounded mx-auto" data-parent="#accordion-one">
            <div class="card-body">
              <h4 class="card-title">Añadir datos del transformador</h4>
              
            </div>
          </div>
          
          
          <div id="collapseThree" class="collapse card mt-2" data-parent="#accordion-one">
            <div class="card-body">3</div>
          </div> -->
        </div>
      </div>
    </div>

  </div>

  <?php include "./modulos/scripts.php"; ?>
</body>

</html>
