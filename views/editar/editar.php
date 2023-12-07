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
  if($_SESSION['tipo'] == "Normal" && !isset($_GET['cuenta'])) {
    header('Location: http://localhost/sistema-transformadores/dashboard');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Editar | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php 
    include "./modulos/menu.php"; 
    include "./conexiones/funciones.php"; 
  ?>

    <div class="d-flex flex-row justify-content-between mb-0 ms-3">
      <?php
          if(isset($_GET['transformador'])) {
                echo '<a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="inventario">';
          } else if(isset($_GET['operacion'])) {
            echo '<a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="historial">';
          } else if(isset($_GET['cuenta'])) {
            echo '<a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="configuraciones">';
          }
        ?>
        <i class="bx bx-arrow-back text-primary"></i> Volver
      </a>
    </div>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 mt-3">
    <h4 class="fw-bold mb-0">Editar <?php if(isset($_GET['transformador'])) {echo "Transformador";} else if(isset($_GET['operacion'])) {echo "Operación";} else if(isset($_GET['cuenta'])) {echo "Cuenta";} ?></h4>
  </div>

    <?php 
      if(isset($_GET['transformador'])) {

        $codigo = strClean($_GET['transformador']);
        $sql = connect()->prepare("SELECT * FROM transformadores WHERE T_Codigo = '$codigo'");

      } else if(isset($_GET['operacion'])) {
  
        $codigo = strClean($_GET['operacion']);
        $sql = connect()->prepare("SELECT * FROM operaciones WHERE O_Codigo = '$codigo'");

      } else if(isset($_GET['cuenta'])) {
  
        $codigo = strClean($_GET['cuenta']);

        if($_SESSION['tipo'] == "Normal" && $_SESSION['codigo'] != $codigo) {
          header('Location: http://localhost/sistema-transformadores/dashboard');
        } 
        
        $sql = connect()->prepare("SELECT * FROM usuarios WHERE userCodigo = '$codigo'");
      }

      if(!isset($codigo)) {
        header('Location: http://localhost/sistema-transformadores/dashboard');
      }

      $sql->execute();
      $data = $sql->fetch(PDO::FETCH_OBJ);
    ?>

  <div class="container-fluid p-4">
    <div class="card col-10 mx-auto">
      <div class="card-body">
        <?php
      if(isset($_GET['transformador'])) {
        echo '<h4 class="card-title">Editar datos</h4>
          <form action="' . SERVERURL . 'conexiones/inventario.php?updateT" name="TUpdate" id="TUpdate" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
            <div class="form-group">
              <label for="TCodigoUpdate" class="text-dark">N° Serial</label>
              <input id="TCodigoUpdate" readonly="" value="' . $data->T_Codigo . '" onkeypress="return letras(event)" type="text" name="TCodigoUpdate" class="form-control input-default">
            </div>
            <div class="form-group">
              <label for="TCapacidadUpdate" class="text-dark">Capacidad</label>
              <div class="input-group">
                <input id="TCapacidadUpdate" value="' . $data->T_Capacidad . '" type="text" class="form-control input-default" name="TCapacidadUpdate">
                <div class="input-group-append"><span class="input-group-text">W</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="TTipoUpdate" class="text-dark">Tipo</label>
              <select id="TTipoUpdate" class="form-control input-default" name="TTipoUpdate">
                <option value="' . $data->T_Tipo . '" selected="selected">' . $data->T_Tipo . '</option>
                ';
                  if($data->T_Tipo == "Monofásico") {
                    echo '
                      <option value="Bifásico">Bifásico</option>
                      <option value="Trifásico">Trifásico</option>
                    ';
                  } else if($data->T_Tipo == "Bifásico") {
                    echo '
                      <option value="Monofásico">Monofásico</option>
                      <option value="Trifásico">Trifásico</option>
                    ';
                  } else if($data->T_Tipo == "Trifásico") {
                    echo '
                      <option value="Monofásico">Monofásico</option>
                      <option value="Bifásico">Bifásico</option>
                    ';
                  }
                  echo '
              </select>
            </div>
            <div class="form-group">
              <label for="TBancoUpdate" class="text-dark">Banco Transformador</label>
              <p>¿El transformador pertenece a un banco transformador?</p>
              <label class="radio-inline mr-3">
                <input type="radio" name="TBancoUpdate" value="' . $data->T_Banco . '" checked=""> ' . $data->T_Banco . '</label>
                ';
                  if($data->T_Banco == "No") {
                    echo '
                      <label class="radio-inline mr-3">
                        <input type="radio" name="TBancoUpdate"  value="Sí"> Sí</label>
                    ';
                  } else {
                    echo '
                      <label class="radio-inline mr-3">
                        <input type="radio" name="TBancoUpdate"  value="No"> No</label>
                    ';
                  }
                  echo '
            </div>

            <div class="form-group">
              <label for="TMunicipioUpdate" class="text-dark">Ubicación</label>
              <select id="TMunicipioUpdate" class="form-control input-default" name="TMunicipioUpdate">
                <option value="' . $data->T_Municipio . '" selected="selected">' . $data->T_Municipio . '</option>
                ';
                        
                  $sql = "SELECT * FROM municipios";
                  $result = connect()->query($sql);
                                
                  while ($rows = $result->fetch()) {
                    echo'<option value="' . $rows['M_Nombre'] . '">' . $rows['M_Nombre'] . '</option>';
                  };  
                echo '
              </select>
            </div>
            <div class="form-group">
              <label for="TEstadoUpdate" class="text-dark">Estado Actual</label>
              <select id="TEstadoUpdate" class="form-control input-default" name="TEstadoUpdate">
                <option value="' . $data->T_Estado . '" selected="selected">' . $data->T_Estado . '</option>
                ';
                  if($data->T_Estado == "Instalado") {
                    echo '
                      <option value="Dañado">Dañado</option>
                      <option value="Almacenado">Almacenado</option>
                    ';
                  } else if($data->T_Estado == "Dañado") {
                    echo '
                      <option value="Instalado">Instalado</option>
                      <option value="Almacenado">Almacenado</option>
                    ';
                  } else if($data->T_Estado == "Almacenado") {
                    echo '
                      <option value="Instalado">Instalado</option>
                      <option value="Dañado">Dañado</option>
                    ';
                  }
                echo '
              </select>
            </div>
            <div class="form-group">
              <label for="TDireccionUpdate" class="text-dark">Dirección</label>
              <textarea value="' . $data->T_Direccion . '" id="TDireccionUpdate" class="form-control input-default h-150px" name="TDireccionUpdate" rows="6" id="comment">' . $data->T_Direccion . '</textarea>
            </div>            
            <div class="RespuestaAjax mt-3"></div> 
            
            <button type="submit" class="btn btn-primary">Editar datos</button>
          </form>
          ';
          } else if(isset($_GET['operacion'])) {
            echo '<h4 class="card-title">Editar datos</h4>
              <form action="' . SERVERURL . 'conexiones/historial.php?updateO" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
              <input value="' . $data->O_Codigo . '" type="hidden" name="HCodigoUpdate">
              <input value="' . $data->O_Municipio . '" type="hidden" name="HMunicipioUpdate">
              <div class="form-group">
                <label for="HProcUpdate" class="text-dark">Procedimiento</label>
                <select id="HProcUpdate" class="form-control input-default" name="HProcUpdate">
                  <option value="' . $data->O_Procedimiento . '" selected="selected">' . $data->O_Procedimiento . '</option>
                  
                  ';
                  if($data->O_Procedimiento == "Reparación") {
                    echo '
                    <option value="Almacenamiento">Almacenamiento</option>
                    <option value="Instalación">Instalación</option>
                    <option value="Retiro">Retiro</option>
                    ';
                  } else if($data->O_Procedimiento == "Almacenamiento") {
                    echo '
                    <option value="Reparación">Reparación</option>
                    <option value="Instalación">Instalación</option>
                    <option value="Retiro">Retiro</option>
                    ';
                  } else if($data->O_Procedimiento == "Instalación") {
                    echo '
                      <option value="Reparación">Reparación</option>
                      <option value="Almacenamiento">Almacenamiento</option>
                      <option value="Retiro">Retiro</option>
                    ';
                  } else if($data->O_Procedimiento == "Retiro") {
                    echo '
                      <option value="Reparación">Reparación</option>
                      <option value="Almacenamiento">Almacenamiento</option>
                      <option value="Instalación">Instalación</option>
                    ';
                  }
                echo '
                </select>
              </div>
              <div class="form-group">
                <label for="HFechaUpdate" class="text-dark">Fecha</label>
                <input id="HFechaUpdate" value="' . $data->O_Fecha . '" type="date" class="form-control input-default" name="HFechaUpdate">
              </div>
              <div class="form-group">
                <label for="HEquipoUpdate" class="text-dark">N° Serial del transformador</label>
                <input id="HEquipoUpdate" value="' . $data->O_Equipo . '" readonly="" type="text" class="form-control input-default" name="HEquipoUpdate" placeholder="Ingrese el número serial del transformador">
              </div>
              <div class="form-group">
                <label for="HEstadoUpdate" class="text-dark">Estado del transformador</label>
                <select id="TEstadoAdd" class="form-control input-default" name="HEstadoUpdate">
                  <option value="' . $data->O_EstadoActual . '" selected="selected">' . $data->O_EstadoActual . '</option>
                  ';
                  if($data->O_EstadoActual == "Instalado") {
                    echo '
                    <option value="Dañado">Dañado</option>
                    <option value="Almacenado">Almacenado</option>
                    ';
                  } else if($data->O_EstadoActual == "Dañado") {
                    echo '
                    <option value="Instalado">Instalado</option>
                    <option value="Almacenado">Almacenado</option>
                    ';
                  } else if($data->O_EstadoActual == "Almacenado") {
                    echo '
                      <option value="Instalado">Instalado</option>
                      <option value="Dañado">Dañado</option>
                    ';
                  }
                  echo '
                </select>
              </div>

              <div class="RespuestaAjax mt-3"></div> 
              <button type="submit" class="btn btn-primary">Editar datos</button>
              </form>
              ';
            } else if(isset($_GET['cuenta'])) {
              echo '<h4 class="card-title">Editar datos</h4>
                <form action="' . SERVERURL . 'conexiones/create.php?updateC" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
                  <div class="form-group">
                    <label for="nombreUpdate" class="form-label">Nombre</label>
                    <input type="text" value="' . $data->userName . '" name="nombreUpdate" onkeypress="return letras(event)" id="nombreUpdate" class="form-control input-default" />
                  </div>

                  <input type="hidden" name="codigoUpdate" value="' . $data->userCodigo . '" />
                  <input type="hidden" name="contrasenaUpdate" value="' . $data->userPassword . '" />
                  <input type="hidden" name="correoCheck" value="' . $data->userEmail . '" />
                  <input type="hidden" name="userCheck" value="' . $data->userUsername . '" />

                  <div class="form-group">
                    <label for="apellidoUpdate" class="form-label">Apellido</label>
                    <input type="text" value="' . $data->userLastname . '" name="apellidoUpdate" onkeypress="return letras(event)" id="apellidoUpdate" class="form-control input-default" />
                  </div>

                  <div class="form-group">
                    <label for="cargoUpdate" class="form-label">Nombre de Cargo</label>
                    <input type="text" value="' . $data->userCargo . '" name="cargoUpdate" id="cargoUpdate" onkeypress="return letras(event)" class="form-control input-default" />
                  </div>

                  <div class="form-group">
                    <label for="correoUpdate" class="form-label">Correo Eléctronico</label>
                    <input type="text" value="' . $data->userEmail . '" name="correoUpdate" id="correoUpdate" class="form-control input-default" />
                  </div>

                  <div class="form-group">
                    <label for="usuarioUpdate" class="form-label">Nombre de Usuario</label>
                    <input type="text" value="' . $data->userUsername . '" name="usuarioUpdate" id="usuarioUpdate" class="form-control input-default" />
                  </div>

                  <div class="form-group">
                    <label for="tipoUpdate" class="form-label">Tipo de Usuario</label>
                    <select name="tipoUpdate" id="tipoUpdate" class="form-control input-default" >
                      <option value="' . $data->userType . '" selected >' . $data->userType . '</option>
                      ';
                      if($data->userType == "Normal") {
                        echo '<option value="Administrador">Administrador</option>';
                      } else if($data->userType == "Administrador") {
                        echo '<option value="Normal">Normal</option>';
                      }
                    echo '
                    </select>
                  </div>

                  <a class="ml-3 text-primary" href="recover">Editar Contraseña</a><small class="ml-2">(Se cerrará la sesión)</small>

                  <div class="RespuestaAjax mt-3"></div> 
                  <button type="submit" class="btn btn-primary">Editar datos</button>
                </form>
              ';
            }
          ?>
        </div>
    </div>
  </div>

  <?php include "./modulos/scripts.php"; ?>
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
