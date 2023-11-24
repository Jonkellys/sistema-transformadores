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
  <title>Inventario | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>
  <?php include "./conexiones/funciones.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 w-50">
    <h4 class="fw-bold mb-0 w-50">Inventario</h4>
  </div>

  <div class="container-fluid p-4">

    <div class="d-flex flex-row justify-content-space ml-5">
      <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-plus-circle"></i> Añadir Transformador</button>
        <!-- <button class="mb-0 btn btn-info mx-1" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-edit"></i> Editar Transformador</button>
        <button class="mb-0 btn btn-danger mx-1" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-trash"></i> Eliminar Transformador</button> -->
    </div>

    <div id="accordion-one" class="accordion">
      <div id="collapseOne" class="collapse card mt-3 col-9 rounded mx-auto" data-parent="#accordion-one">
        <div class="card-body">
          <h4 class="card-title">Añadir datos del transformador</h4>
          <form action="<?php echo SERVERURL; ?>conexiones/inventario.php?addT" name="TAdd" id="TAdd" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
            <input type="hidden" name="TAddInput">  
            <div class="form-group">
              <label for="TCodigoAdd" class="text-dark">N° Serial</label>
              <input id="TCodigoAdd" onkeypress="return letras(event)" type="text" name="TCodigoAdd" class="form-control input-default" placeholder="Ingrese el número serial del transformador">
            </div>
            <div class="form-group">
              <label for="TCapacidadAdd" class="text-dark">Capacidad</label>
              <div class="input-group">
                <input id="TCapacidadAdd" type="text" class="form-control input-default" name="TCapacidadAdd" placeholder="¿Cuánta capacidad genera el transformador?">
                <div class="input-group-append"><span class="input-group-text">W</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="TTipoAdd" class="text-dark">Tipo</label>
              <select id="TTipoAdd" class="form-control input-default" name="TTipoAdd">
                <option disabled selected="selected">Seleccione el tipo de transformador?</option>
                <option value="Monofásico">Monofásico</option>
                <option value="Bifásico">Bifásico</option>
                <option value="Trifásico">Trifásico</option>
              </select>
            </div>
            <div class="form-group">
              <label for="TBancoAdd" class="text-dark">Banco Transformador</label>
              <p>¿El transformador pertenece a un banco transformador?</p>
              <label class="radio-inline mr-3">
                <input type="radio" name="TBancoAdd" value="No" checked=""> No</label>
          
              <label class="radio-inline mr-3">
                <input type="radio" name="TBancoAdd"  value="Sí"> Sí</label>
            </div>

            <div class="form-group">
              <label for="TMunicipioAdd" class="text-dark">Ubicación</label>
              <select id="TMunicipioAdd" class="form-control input-default" name="TMunicipioAdd">
                <option disabled selected="selected">¿En donde está ubicado el transformador?</option>
                <?php
                        
                  $sql = "SELECT * FROM municipios";
                  $result = connect()->query($sql);
                                
                  while ($rows = $result->fetch()) {
                    echo'<option value="' . $rows['M_Nombre'] . '">' . $rows['M_Nombre'] . '</option>';
                  };  
                ?>
              </select>
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
              <label for="TDireccionAdd" class="text-dark">Dirección</label>
              <textarea id="TDireccionAdd" class="form-control input-default h-150px" name="TDireccionAdd" rows="6" id="comment"></textarea>
            </div>            
            <div class="RespuestaAjax mt-3"></div> 
            
            <button type="submit" class="btn btn-primary">Añadir datos</button>
          </form>
        </div>
      </div>  
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
                <th>Capacidad Instalada</th>
                <th>Ubicación</th>
                <th>Dirección</th>
                <th>Tipo</th>
                <th>Banco Transformador</th>
                <th>Acciones</th>
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
                        <td>" . $rows['T_Tipo'] . "</td>
                        <td>" . $rows['T_Banco'] . "</td>
                        <td class='mt-0'>
                          <a class='btn btn-sm btn-info' href='editar?transformador=" . $rows['T_Codigo'] . "'>
                            <span class='tf-icons bx bx-edit'></span>
                          </a>

                          <a class='btn btn-sm btn-danger' href='delete?transformador=" . $rows['T_Codigo'] . "'>
                            <span class='tf-icons bx bx-trash'></span>
                          </a>


                        </td>
                  </tr>";
                };  
              ?>
              <!-- <a class='btn btn-sm btn-danger' href= 'conexiones/eliminarPersonal.php?serial=" . $rows['T_Codigo'] . "'>
                            <span class='tf-icons bx bx-trash'></span>
                          </a> -->

                          <!-- <form action='" . SERVERURL . "conexiones/inventario.php?deleteT' name='Tdelete' id='Tdelete' autocomplete='off' enctype='multipart/form-data' method='POST' data-form='delete' class='FormularioAjax p-3'>
                            <input type='hidden' name='delT' value='" . $rows['T_Codigo'] . "' />
                            <div class='RespuestaAjax mt-3'></div> 
                          
                            <button class='btn btn-sm btn-danger' type='submit'><span class='tf-icons bx bx-trash'></span></button>
                          </form> -->
                          
            </tbody>
          </table>
        </div>
      </div>
    </div>

    

  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/principal.js"></script>
  <script>
    function letras(e) {
        tecla = (document.all) ? e.keyCode : e.which;


        if (tecla == 32) {
          return true;
        }

        patron = /[a-zA-Z0-9]/gi;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
      }
  </script>
  <script src="<?php echo media; ?>extras/datatables/config.js"></script>

</body>

</html>
