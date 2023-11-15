<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Crear Cuenta | <?php echo NOMBRE; ?></title>
</head>

<body class="gradient-7 p-4 vw-100 vh-100">
  <div class="d-flex flex-row justify-content-between mb-4">
    <a class="btn btn-outline-light py-2 text-white ml-4" href="./">
      <i class="bx bx-arrow-back"></i> Volver
    </a>
    <a class="btn btn-outline-light py-2 text-white mr-4" href="ayuda">
      <i class="bx bx-help-circle"></i> Ayuda
    </a>
  </div>

  <div class="card mx-auto border-0 col-8 p-4">
    <div class="text-center">
      <h1 class="h3 font-weight-bold text-gray-900 mb-2 mt-2">Crea un Usuario 📝</h1>
      <h4 class="text-primary">Datos Personales</h4>
    </div>


    <form action="<?php echo SERVERURL; ?>conexiones/create.php" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
                          
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
                            <div class="form-group col-md-6 mx-auto">
                            <label for="cargoAdd" class="form-label">Nombre de Cargo</label>
                              <input type="text" name="cargo" id="cargoAdd" class="form-control input-default" placeholder="Ingresar Cargo" />
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
  <?php include "./modulos/scripts.php"; ?>
<script src="<?php echo media; ?>js/ajax/principal.js"></script>
  <script>
    $("#nextBtn").click(function(){
      $("#userData").hide();
      $("#peopleData").show();
    });

    $("#backBtn").click(function(){
      $("#userData").show();
      $("#peopleData").hide();
    });

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
