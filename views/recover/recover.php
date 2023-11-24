<?php $page = "recover"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Recuperar Contraseña | <?php echo NOMBRE; ?></title>
</head>

<body class="d-flex flex-column align-items-start bg-body" style="width: 100vw;">

  <?php include "./modulos/header.php"; ?>

  <div class="d-flex mt-2 flex-row justify-content-between mb-0 ms-3">
    <a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="login">
      <i class="bx bx-arrow-back"></i> Volver
    </a>
  </div>

  <div class="card mb-4 col-4 d-flex flex-column align-items-center p-3 mx-auto mt-5">
    <h3 class="mb-3 text-primary">¿Olvidaste tu Contraseña? 🔒</h3>
    <p>Ingresa tu Correo y sigue las instrucciones.</p>
    <form action="<?php echo SERVERURL; ?>conexiones/recovery.php?emailTrial" id="recover-form" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3 col-10">              
      <div class="form-group col-12">
        <label for="recoverForm" class="form-label">Correo</label>
        <input type="email" name="recoverForm" id="recoverForm" class="form-control input-default " placeholder="Correo" />
      </div>
      
      <div id="respuesta" class="RespuestaAjax mt-3"></div> 
      <div class="d-flex flex-column align-items-center justify-content-center">
        <button class="btn btn-primary mx-auto" value="submit" name="submit" id="btn" type="submit">Comprobar</button>
      </div>
                    
    </form>
  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/login.js"></script>
</body>

</html>
