<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

  $page = "ubicaciones";

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
  <title>Ubicaciones | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 2-50">
    <h4 class="fw-bold mb-0">Ubicaciones</h4>
  </div>
  
  <div class="container-fluid p-4">

    <div class="col-lg-10 mx-auto">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Seleccione una ubicación</h4>
          <div class="basic-form mx-auto">
            <form action="<?php echo SERVERURL; ?>conexiones/ubicaciones.php" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
              <div class="form-group">
                <h5 class="text-dark">Municipios</h5>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Andrés Mata"> Andrés Mata</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Arismendi"> Arismendi</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Benítez"> Benítez</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Bermúdez"> Bermúdez</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Cajigal"> Cajigal</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Libertador"> Libertador</label>
                <label class="radio-inline mr-3">
                <input type="radio" name="radMun" value="Mariño"> Mariño</label>
                <label class="radio-inline">
                <input type="radio" name="radMun" value="Valdez"> Valdez</label>
                <br>
                <br>
                <h5 class="text-dark">Otros</h5>
                <label class="radio-inline">
                <input type="radio" name="radMun" value="Central de Servicios"> Central de Servicios</label>
              </div>
              <div id="respuesta" class="RespuestaAjax mt-1"></div> 
              <div class="d-flex flex-column align-items-center justify-content-center">
                <button class="btn btn-primary mx-auto" value="submit" name="submit" id="btn" type="submit">Buscar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    include "./conexiones/funciones.php";

    $mun = $_GET['municipio'];
    
    if(isset($mun)) {
      if($mun == "Central de Servicios") {
        echo '<div class="col-11 mx-auto">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3">Central de Servicios</h5>
            <div class="basic-list-group d-flex flex-row justify-content-center">
    
             <div class="col-2 p-0 m-2">
                <div class="card-body d-flex flex-column align-items-center">
                  <h5 class="card-title text-center">Transformadores Dañados</h5>
                  <span class="badge badge-danger badge-pill font-tiny text-white">' . getMunCount('Dañado', $mun) . '</span>
                </div>
              </div> 
  
              <div class="col-2 p-0 m-2">
                <div class="card-body d-flex flex-column align-items-center">
                  <h5 class="card-title text-center">Transformadores en Stock</h5>
                  <span class="badge badge-info badge-pill font-tiny text-white">' . getMunCount('Almacenado', $mun) . '</span>
                </div>
              </div>
  
              <div class="col-2 p-0 m-2">
                <div class="card-body d-flex flex-column align-items-center">
                  <h5 class="card-title text-center">Transformadores Totales</h5>
                  <span class="badge badge-primary badge-pill font-tiny text-white">' . getMunCount(false, $mun) . '</span>
                </div>
              </div>
  
            </div>';
      } else {
    echo '<div class="col-11 mx-auto">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-3">Municipio ' . $mun . '</h5>
          <div class="basic-list-group d-flex flex-row justify-content-center">

            <div class="col-2 p-0 m-2">
              <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title text-center">Transformadores Instalados</h5>
                <span class="badge badge-success badge-pill font-tiny text-white">' . getMunCount('Instalado', $mun) . '</span>
              </div>
            </div>

           <div class="col-2 p-0 m-2">
              <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title text-center">Transformadores Dañados</h5>
                <span class="badge badge-danger badge-pill font-tiny text-white">' . getMunCount('Dañado', $mun) . '</span>
              </div>
            </div> 

            <div class="col-2 p-0 m-2">
              <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title text-center">Transformadores Totales</h5>
                <span class="badge badge-primary badge-pill font-tiny text-white">' . getMunCount(false, $mun) . '</span>
              </div>
            </div>

            <div class="col-2 p-0 m-2">
              <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title text-center">Capacidad Instalada</h5>
                <span class="badge badge-warning badge-pill font-tiny text-white">' . getMunCapacidad($mun) . '</span>
              </div>
            </div>
          </div>';
          }

          echo '<div class="table-responsive mt-3">
            <table class="table table-striped table-hover" id="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>N° Serial</th>
                  <th>Estado</th>
                  <th>Capacidad</th>
                  <th>Dirección</th>
                  <th>Tipo</th>
                  <th>Banco Transformador</th>
                </tr>
              </thead>
              <tbody>
                ';
                  $result = connect()->query("SELECT * FROM transformadores WHERE T_Municipio = '$mun'");
                
                  $num = 1;

                  while ($rows = $result->fetch()) {
                    echo"<tr>
                          <th> <strong>" . $num++ . "</strong></th>
                          <td><a class='text-info' href='transformador?serial=" . $rows['T_Codigo'] . "'>" . $rows['T_Codigo'] . "</a></td>
                          <td>" . $rows['T_Estado'] . "</td>
                          <td>" . $rows['T_Capacidad'] . " w</td>
                          <td>" . $rows['T_Direccion'] . "</td>
                          <td>" . $rows['T_Tipo'] . "</td>
                          <td>" . $rows['T_Banco'] . "</td>
                        </tr>";
                  };  

                echo ' 
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>';
    }

    ?>

  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/buscar.js"></script>
  <script src="<?php echo media; ?>extras/datatables/config.js"></script>
</body>

</html>
