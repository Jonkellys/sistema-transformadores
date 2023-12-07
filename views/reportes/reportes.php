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
  <?php include "./conexiones/funciones.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5">
    <h4 class="fw-bold mb-0">Reportes</h4>
  </div>

  <div class="container-fluid p-4">

        
    <div id="accordion-one" class="accordion ml-5 card mx-auto p-4 col-9">
      <h4 class="card-title">Seleccione una Opción</h4>
      <div class="d-flex flex-row justify-content-space">
        <a class="mb-0 btn btn-primary mx-1" href="<?php echo SERVERURL; ?>conexiones/reportes.php?tipo=general" target="_blank" rel="noopener noreferrer"><i class="bx bxs-file-pdf text-white"></i> Reporte General</a>
            
        <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-file text-white"></i> Reporte Personalizado</button>
      </div>
    </div>

    <div id="collapseOne" class="collapse card mt-3 col-10 rounded mx-auto" data-parent="#accordion-one">
      <div class="card-body">
        <h4 class="card-title">Elija un tema y las opciones para generar el informe</h4>
        <form id="reportForm" action="<?php echo SERVERURL; ?>conexiones/reportes.php?tipo=personalizado" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="report" class="FormularioAjax p-3">
          <div class="d-flex flex-row">
            <div class="col-6 mr-2 ml-2">
              <p class="mb-2 text-dark font-weight-bold">Temas:</p>
              <div class="form-group">
                <label for="TCheck" class="text-dark">Transformadores</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input name="TCheck" value="on" id="theme" type="checkbox" />
                    </div>
                  </div>
                  <input type="text" class="form-control bg-white" readonly="" placeholder="Incluir información sobre los transformadores" />
                </div>
              </div>

              <p class="mb-2 mt-4 text-dark font-weight-bold">Categorias:</p>

                <div class="form-group">
                  <label for="EstadoInput" class="text-dark">Estado</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="EstadoCheck" value="on" type="checkbox" />
                      </div>
                    </div>
                    <select id="EstadoInput" class="form-control input-default" name="EstadoInput">
                      <option disabled selected="selected">Seleccione un estado</option>
                      <option value="Todos">Todos</option>
                      <option value="Instalado">Instalado</option>
                      <option value="Dañado">Dañado</option>
                      <option value="Almacenado">Almacenado</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="UbicacionInput" class="text-dark">Ubicación</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="UbicacionCheck" value="on" type="checkbox" />
                      </div>
                    </div>
                    <select id="UbicacionInput" class="form-control input-default" name="UbicacionInput">
                      <option disabled selected="selected">Seleccione una Ubicación</option>
                      <option value="Todos">Todos</option>
                      <?php
                        
                        $sql = "SELECT * FROM municipios";
                        $result = connect()->query($sql);
                                      
                        while ($rows = $result->fetch()) {
                          echo'<option value="' . $rows['M_Nombre'] . '">' . $rows['M_Nombre'] . '</option>';
                        };  
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="TipoInput" class="text-dark">Tipo y Banco Transformador</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="TipoCheck" value="on" type="checkbox" />
                      </div>
                    </div>
                    <select id="TipoInput" class="form-control input-default" name="TipoInput">
                      <option disabled selected="selected">Seleccione un Tipo</option>
                      <option value="Todos">Todos</option>
                      <option value="Monofásico">Monofásico</option>
                      <option value="Bifásico">Bifásico</option>
                      <option value="Trifásico">Trifásico</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-6 ">
                <p class="mb-2 invisible">  l</p>
                <div class="form-group">
                  <label for="OCheck" class="text-dark">Operaciones</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="OCheck" value="on" id="theme" type="checkbox" />
                      </div>
                    </div>
                    <input type="text" class="form-control bg-white" readonly="" placeholder="Incluir información sobre las operaciones" />
                  </div>
                </div>

                <p class="mb-2 mt-4 invisible">  l</p>

                <div class="form-group">
                  <label for="ProcInput" class="text-dark">Procedimiento</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="ProcCheck" value="on" type="checkbox" />
                      </div>
                    </div>
                    <select id="ProcInput" class="form-control input-default" name="ProcInput">
                      <option disabled selected="selected">Seleccione un Procedimiento</option>
                      <option value="Todos">Todos</option>
                      <option value="Reparación">Reparación</option>
                      <option value="Almacenamiento">Almacenamiento</option>
                      <option value="Instalación">Instalación</option>
                      <option value="Retiro">Retiro</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="UbicacionProcInput" class="text-dark">Ubicación del Procedimiento</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="UbicacionProcCheck" value="on" type="checkbox" />
                      </div>
                    </div>
                    <select id="UbicacionProcInput" class="form-control input-default" name="UbicacionProcInput">
                      <option disabled selected="selected">Seleccione una Ubicación</option>
                      <option value="Todos">Todos</option>
                      <?php
                        
                        $sql = "SELECT * FROM municipios";
                        $result = connect()->query($sql);
                                      
                        while ($rows = $result->fetch()) {
                          echo'<option value="' . $rows['M_Nombre'] . '">' . $rows['M_Nombre'] . '</option>';
                        };  
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="FechaCheck" class="text-dark">Fecha</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><input name="FechaCheck" value="on" type="checkbox" /></span>
                    </div>
                    <input type="date" name="FechaInicio" placeholder="Desde:" class="form-control">
                    <input type="date" name="FechaFin" placeholder="Hasta:" class="form-control">
                  </div>
                  <p>Deje en blanco para mostrar todas, o seleccione fechas de inicio y fin</p>
                </div>
              </div>

            </div>


          <div id="respuesta" class="RespuestaAjax mt-0"></div> 
          
          <div class="d-flex flex-row justify-content-center mb-4">
            <button class="btn btn-primary mr-3" value="submit" name="submit" id="btn" type="submit">Generar</button>
            <button class="btn btn-outline-primary" onclick= "clearInput()" type="button">Limpiar</button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/principal.js"></script>
  <script>
    function clearInput() {
      document.getElementById("reportForm").reset();
    }
  </script>
</body>

</html>
