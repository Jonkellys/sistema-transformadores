<?php
  date_default_timezone_set("America/Caracas");
  include "./conexiones/funciones.php";

   session_start(['name' => 'Sistema']);

  if(!isset($_SESSION['token']) || !isset($_SESSION['usuario'])) {
    unset($_SESSION['id']);
    unset($_SESSION['codigo']);
    unset($_SESSION['usuario']);
    unset($_SESSION['clave']);
    unset($_SESSION['tipo']);
    unset($_SESSION['nombre']);
    unset($_SESSION['apellido']);
    unset($_SESSION['correo']);
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
  <title>Configuraciones | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php
   include "./modulos/menu.php";
  ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 2-50">
    <h4 class="fw-bold mb-0">Configuraciones</h4>
  </div>

  <div class="container-fluid p-4">
    <div class="card col-10 mx-auto p-4">
      <div>
        <h4>Perfil</h4>
        <div class="ml-4 mt-3 d-flex flex-row flex-wrap">
          <div class="form-group col-4">
            <label class="text-dark">Nombre</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['nombre']; ?>" >
          </div>
          <div class="form-group col-4">
            <label class="text-dark">Apellido</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['apellido']; ?>" >
          </div>
          <div class="form-group col-4">
            <label class="text-dark">Correo</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['correo']; ?>" >
          </div>
          <div class="form-group col-4">
            <label class="text-dark">Cargo</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['cargo']; ?>" >
          </div>
          <div class="form-group col-4">
            <label class="text-dark">Nombre de Usuario</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['usuario']; ?>" >
          </div>
          <div class="form-group col-4">
            <label class="text-dark">Tipo de Usuario</label>
            <input readonly="" type="text" class="form-control input-default" placeholder="<?php echo $_SESSION['tipo']; ?>" >
          </div>
          <?php
            if($_SESSION['tipo'] == "Normal") {
              echo '
                <a class="text-primary" href="editar?cuenta=' . $_SESSION['codigo'] . '">Editar Datos</a>
              ';
            }
          ?>
        </div>
      </div>
    </div>
    <?php
        if($_SESSION['tipo'] == "Administrador") {
        echo '

    <div class="card col-10 mx-auto p-4">
      <div class="">
        <h4>Cuentas</h4>
        <div id="accordion-one" class="accordion">
          <div class="d-flex flex-row justify-content-space my-4">
            <button class="mb-0 btn btn-primary mx-1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="bx bx-plus-circle text-white"></i> Añadir Cuenta</button>
          </div>
          
          <div id="collapseOne" class="collapse mt-3 col-11 mx-auto" data-parent="#accordion-one">
            <div class="card-body">
            <h4 class="mb-4 text-primary text-center">Datos Personales</h4>
              <form action="' . SERVERURL . 'conexiones/create.php?CAdd" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">          
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="nombreAdd" class="form-label">Nombre</label>
                    <input type="text" autocapitalize="" name="nombre" onkeypress="return letras(event)" id="nombreAdd" class="form-control input-default " placeholder="Ingresar Nombre" />
                  </div>

                  <div class="form-group col-md-6">
                    <label for="apellidoAdd" class="form-label">Apellido</label>
                    <input type="text" autocapitalize="" name="apellido" onkeypress="return letras(event)" id="apellidoAdd" class="form-control input-default" placeholder="Ingresar Apellido" />
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="cargoAdd" class="form-label">Nombre de Cargo</label>
                    <input type="text" name="cargo" id="cargoAdd" onkeypress="return letras(event)" class="form-control input-default" placeholder="Ingresar Cargo" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="correoAdd" class="form-label">Correo Eléctronico</label>
                    <input type="text" name="correo" id="correoAdd" class="form-control input-default" placeholder="Ingresar Correo" />
                  </div>
                </div>

                <br>
                <br>

                <h4 class="mb-4 text-primary text-center">Datos de la Cuenta</h4>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="usuarioAdd" class="form-label">Nombre de Usuario</label>
                    <input type="text" name="usuario" id="usuarioAdd" class="form-control input-default" placeholder="Ingresar Nombre de Usuario" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="tipoAdd" class="form-label">Tipo de Usuario</label>
                    <select name="tipo" id="tipoAdd" class="form-control input-default" >
                      <option disabled selected >Selecciona una opción</option>
                      <option value="Normal">Normal</option>
                      <option value="Administrador">Administrador</option>
                    </select>
                  </div>

                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="clave1Add" class="form-label">Contraseña</label>
                    <input type="password" name="clave"  id="clave1Add" class="form-control input-default" placeholder="Ingresar Contraseña" />
                  </div>

                  <div class="form-group col-md-6">
                    <label for="clave2Add" class="form-label">Repetir Contraseña</label>
                    <input type="password" name="confirmar"  id="clave2Add" class="form-control input-default" placeholder="Ingresar Contraseña Nuevamente" />
                  </div>
                </div>
                <br>
                <div id="respuesta" class="RespuestaAjax mt-3"></div> 
                <div class="d-flex flex-column align-items-center justify-content-center">
                  <button class="btn btn-primary mx-auto" value="submit" name="submit" id="btn" type="submit">Crear Cuenta</button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-hover" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Cargo</th>
                <th>Nombre de Usuario</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>';
                $result = connect()->query("SELECT * FROM usuarios");
                $num = 1;

                while ($rows = $result->fetch()) {
                  if($rows['userUsername'] == $_SESSION['usuario']) {
                    echo"<tr class='table-primary'>";
                  } else {
                    echo"<tr>";
                  };

                      echo "<th> <strong>" . $num++ . "</strong></th>
                        <td>" . $rows['userName'] . "</td>
                        <td>" . $rows['userLastname'] . "</td>
                        <td>" . $rows['userEmail'] . "</td>
                        <td>" . $rows['userCargo'] . "</td>
                        <td>" . $rows['userUsername'] . "</td>
                        <td>" . $rows['userType'] . "</td>
                        <td class='mt-0'>
                          <a class='btn btn-sm btn-info' href='editar?cuenta=" . $rows['userCodigo'] . "'>
                            <span class='tf-icons bx bx-edit text-white'></span>
                          </a>

                          <a class='btn btn-sm btn-danger' href='delete?cuenta=" . $rows['userCodigo'] . "'>
                            <span class='tf-icons bx bx-trash text-white'></span>
                          </a>


                        </td>
                  </tr>";
                }; 
                          
            echo '</tbody>
          </table>
        </div>';
        }
        ?>
      </div>

    </div>
  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>extras/datatables/config.js"></script>
  <script src="<?php echo media; ?>js/ajax/principal.js"></script>
  <script>
    function letras(e) {
        tecla = (document.all) ? e.keyCode : e.which;

        if (tecla == 8) {
          return true;
        }

        if (tecla == 32) {
          return true;
        }

        patron = /[A-Za-z]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
      }
  </script>
</body>

</html>
