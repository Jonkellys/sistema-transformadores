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
    header('Location: http://localhost/sistema-transformadores/login');
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

<body class="bg-body" style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-3">
    <h4 class="fw-bold mb-3">Inicio</h4>
  </div>

  <div class="page-breadcrumb ml-5">
    <div class="row">
      <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Buenos Días, <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></h3>
        <p style="width: fit-content;" class="font-tiny"><?php echo $_SESSION['cargo']; ?></p>
      </div>
    </div>
  </div>

  
  <div class="container-fluid p-4">

    <div class="card-group col-11 mx-auto">
    <?php
     include "./conexiones/funciones.php";
    ?>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo getMunCount('Instalado', false); ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores Instalados</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-3 text-muted"><i class="bx bx-calendar-alt font-big text-success"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo getMunCount('Dañado', false); ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores Dañados</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-3 text-muted"><i class="bx bx-calendar-alt font-big text-warning"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card border-right">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo getMunCount('Almacenado', false); ?></h2>
              </div>
              <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Transformadores en Stock</h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-3 text-muted"><i class="bx bx-calendar-alt font-big text-info"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <div class="d-inline-flex align-items-center">
                <h2 class="text-dark mb-1 font-weight-medium"><?php echo getMunCapacidad(false); ?></h2>
              </div>
              <h6 class="text-gray font-weight-normal mb-0 w-100 text-truncate">Capacidad Instalada</h6>
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
            
            <h5 class="card-title fw-semibold mt-1 mb-4">Historial de Operaciones</h5>
            <?php
              $result = connect()->query("SELECT * FROM operaciones LIMIT 8");

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

                echo '<div class="d-flex flex-row justify-content-center font-tiny mt-0">
                        <p class="text-muted">' . $rows['O_Fecha'] . '</p>
                        <i class="bx bx-circle ' . $color . ' mx-2 mt-1 font-weight-bold"></i>
                        <p class="text-dark">' . $rows['O_Procedimiento'] . ' - <a href="transformador?serial=' . $rows['O_Equipo'] . '">' . $rows['O_Equipo'] . '</a></p>
                      </div>
                ';
              };  
            ?>
          
          </div>
        </div>
      </div>

    </div>

  </div>
  
  <?php include "./modulos/scripts.php"; ?>
  <script type="module" src="<?php echo media; ?>extras/chartjs/chart.umd.min.js"></script>
  <script type="module">
    const funcData = <?php echo json_encode(funcData("Instalado")) ?>;
    const damData = <?php echo json_encode(funcData("Dañado")) ?>;
    const data = {
      labels: ["Andrés Mata", "Arismendi", "Benítez", "Bermúdez", "Cajigal", "Libertador", "Mariño", "Valdez"],
      datasets: [{
        label: "Instalado",
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
