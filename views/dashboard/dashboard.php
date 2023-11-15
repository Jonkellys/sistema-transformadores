<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

  $page = "dashboard";

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
    header('Location: http://localhost:85/sistema-transformadores/login');
  }
?>

<!DOCTYPE html>
<html lang="en" style="width: 100vw;">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Inicio | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-3">
    <h4 class="fw-bold mb-4">Inicio</h4>
  </div>

  <div class="page-breadcrumb ml-5">
    <div class="row">
      <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Buenos Días, <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></h3>
      </div>
    </div>
  </div>

  
  <div class="container-fluid p-4">

    <div class="card-group col-11 mx-auto">
    <?php
     include "./conexiones/funciones.php";
     
     $TInstall = ejecutar_consulta_simple("SELECT id FROM transformadores WHERE T_Estado = 'Funcionando'");
     $InstallTotal = ($TInstall->rowCount());
     
     $TDam = ejecutar_consulta_simple("SELECT id FROM transformadores WHERE T_Estado = 'Dañado'");
     $DamTotal = ($TDam->rowCount());
     
     $TAlm = ejecutar_consulta_simple("SELECT id FROM transformadores WHERE T_Estado = 'Almacenado'");
     $AlmTotal = ($TAlm->rowCount());
    ?>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $InstallTotal; ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores Funcionando</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"><i class="bx bx-calendar-alt font-big text-success"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $DamTotal; ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores Dañados</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"><i class="bx bx-calendar-alt font-big text-warning"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo $AlmTotal; ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores Almacenados</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"><i class="bx bx-calendar-alt font-big text-info"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium">1538</h2>
              </div>
              <h6 class="text-gray font-weight-normal mb-0 w-100 text-truncate">Capacidad Generada</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"><i class="bx bx-bulb font-big text-danger"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-5 mb-3 d-flex flex-row justify-content-center">

      <div class="col-lg-7 d-flex align-items-strech card">
        <div class="card-body d-block mb-1">
          <h5 class="card-title fw-semibold">Distribución por Municipios</h5>
          <canvas id="barChart" class="chartjs-render-monitor w-100"></canvas>
        </div>
      </div>

      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body p-4">
            
            <h5 class="card-title fw-semibold mt-1">Historial de Operaciones</h5>
            <?php
              $result = connect()->query("SELECT * FROM operaciones");

              while ($rows = $result->fetch()) {
                if($rows['O_Procedimiento'] == "Retiro") {
                  $color = "text-danger";
                } else if($rows['O_Procedimiento'] == "Instalación") {
                  $color = "text-success";
                } else if($rows['O_Procedimiento'] == "Almacenamiento") {
                  $color = "text-info";
                } else if($rows['O_Procedimiento'] == "Reparación") {
                  $color = "text-warning";
                }

                echo '<div class="d-flex flex-row justify-content-center font-tiny mt-4">
                        <p class="text-muted">' . $rows['O_Fecha'] . '</p>
                        <i class="bx bx-circle ' . $color . ' mx-2 mt-1"></i>
                        <p class="text-dark">' . $rows['O_Procedimiento'] . '</p>
                      </div>
                ';
              };  
            ?>
          
            
          <!-- <div class="d-flex flex-row justify-content-center font-tiny mt-4">
            <p class="text-muted">12/12/1010</p>
            <i class="bx bx-circle text-success mx-2 mt-1"></i>
            <p class="text-bold">Instalación</p>
          </div> -->


          </div>
        </div>
      </div>

    </div>

  </div>
  
  <?php include "./modulos/scripts.php"; ?>
  <script type="module" src="<?php echo media; ?>extras/chartjs/chart.umd.min.js"></script>
  <script type="module">
    const funcData = <?php echo json_encode(funcData()) ?>;
    const damData = <?php echo json_encode(damData()) ?>;
    const data = {
      labels: ["Benítez", "Bermúdez", "Cajigal", "Libertador", "Mariño", "Valdez"],
      datasets: [{
        label: "Funcionando",
        data: funcData,
        borderColor: "rgba(111, 217, 111, 0.9)",
        borderWidth: "0",
        backgroundColor: "rgba(111, 217, 111, 0.5)"
        },
        {
          label: "Dañado",
          data: damData,
          borderColor: "rgba(255, 94, 94, 0.9)",
          borderWidth: "0",
          backgroundColor: "rgba(255, 94, 94, 0.5)"
        }
      ]
    };

    const config = {
      type: 'bar',
      data,
      options: {
        responsive: true,
        layout: {
          padding: 20
        },
        scales: {
          y: { 
            ticks: {stepSize: 1}
          }
       },
      },
    };

    const barChart = new Chart(
      document.getElementById('barChart').getContext("2d"),
      config
    );
  </script>
  
</body>

</html>
