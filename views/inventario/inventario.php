<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

  $page = "inventario";

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
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Inventario | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 w-50">
    <h4 class="fw-bold mb-0 w-50">Inventario</h4>
  </div>

  <div class="container-fluid p-4">

    <div id="accordion-one" class="accordion">
      <div class="d-flex flex-row justify-content-space ml-5">
        <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-plus-circle"></i> Añadir Transformador</button>
        <!-- <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne"></button> -->
      </div>
      <div id="collapseOne" class="collapse card mt-3 col-9 rounded mx-auto" data-parent="#accordion-one">
        <div class="card-body">
          <h4 class="card-title">Añadir datos del transformador</h4>
          <form action="<?php echo SERVERURL; ?>conexiones/inventario.php" name="TAdd" id="TAdd" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
            <input type="hidden" name="TAddInput">  
            <div class="form-group">
              <label for="TCodigoAdd" class="text-dark">N° Serial</label>
              <input id="TCodigoAdd" type="text" name="TCodigoAdd" class="form-control input-default" placeholder="Ingrese el número serial del transformador">
            </div>
            <div class="form-group">
              <label for="TEstadoAdd" class="text-dark">Estado Actual</label>
              <select id="TEstadoAdd" class="form-control input-default" name="TEstadoAdd">
                <option disabled selected="selected">¿Cúal es el estado actual del transformador?</option>
                <option value="Funcionando">Funcionando</option>
                <option value="Dañado">Dañado</option>
                <option value="Almacenado">Almacenado</option>
              </select>
            </div>
            <div class="form-group">
              <label for="TCapacidadAdd" class="text-dark">Capacidad</label>
              <input id="TCapacidadAdd" type="text" class="form-control input-default" name="TCapacidadAdd" placeholder="¿Cuánta capacidad genera el transformador?">
            </div>
            <div class="form-group">
              <label for="TMunicipioAdd" class="text-dark">Municipio</label>
              <select id="TMunicipioAdd" class="form-control input-default" name="TMunicipioAdd">
                <option disabled selected="selected">¿En que municipio está ubicado el transformador?</option>
                  <?php
                    include "./conexiones/funciones.php";
                    
                    $sql = "SELECT * FROM municipios";
                    $result = connect()->query($sql);
                            
                    while ($rows = $result->fetch()) {
                      echo'<option value="' . $rows['M_Nombre'] . '">' . $rows['M_Nombre'] . '</option>';
                    };  
                  ?>
              </select>
            </div>
            <div class="form-group">
              <label for="TDireccionAdd" class="text-dark">Dirección</label>
              <textarea id="TDireccionAdd" class="form-control input-default h-150px" name="TDireccionAdd" rows="6" id="comment"></textarea>
            </div>
            <div class="RespuestaAjax mt-3"></div> 
            
            <button type="submit" class="btn btn-primary">Añadir datos</button>
          </form>
        </div>
      </div>
      
      
      <!-- <div id="collapseThree" class="collapse card mt-2" data-parent="#accordion-one">
        <div class="card-body">3</div>
      </div> -->
    </div>


    <div class="col-lg-11 mx-auto mt-4 card">
      <div class="card-body">
        <div class="card-title">
          <h4>Lista de Transformadores</h4>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>N° Serial</th>
                <th>Estado</th>
                <th>Capacidad</th>
                <th>Municipio</th>
                <th>Dirección</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $result = connect()->query("SELECT * FROM transformadores");
                $num = 1;

                while ($rows = $result->fetch()) {
                  echo"<tr>
                        <th> <strong>" . $num++ . "</strong></th>
                        <td><a class='text-info' href='equipo?serial=" . $rows['T_Codigo'] . "'>" . $rows['T_Codigo'] . "</a></td>
                        <td>" . $rows['T_Estado'] . "</td>
                        <td>" . $rows['T_Capacidad'] . "</td>
                        <td>" . $rows['T_Municipio'] . "</td>
                        <td>" . $rows['T_Direccion'] . "</td>
                      </tr>";
                };  
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    

  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/principal.js"></script>
  <script src="<?php echo media; ?>extras/datatables/config.js"></script>

</body>

</html>
