<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

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

  $page = "newPass";

  if(!isset($_GET['token'])) {
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
  <title>Crear Nueva Contraseña | <?php echo NOMBRE; ?></title>
</head>

<body class="d-flex flex-column align-items-start bg-body" style="width: 100vw;">

  <?php include "./modulos/header.php"; ?>

  <div class="d-flex mt-2 flex-row justify-content-between mb-0 ms-3">
    <a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="recover">
      <i class="bx bx-arrow-back text-primary"></i> Volver
    </a>
  </div>

  <?php
     include "./conexiones/funciones.php";
     $token = strClean($_GET['token']);
  ?>

  <div class="card mb-4 col-4 d-flex flex-column align-items-center p-3 mx-auto mt-5">
    <h3 class="mb-3 text-primary">Crear Nueva Contraseña</h3>
    <form action="<?php echo SERVERURL; ?>conexiones/recovery.php?newPass" id="newPass-form" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3 col-10">              
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">  
      <div class="form-group col-12">
        <label for="newPassForm" class="form-label">Contraseña Nueva</label>
        <input type="password" name="newPassForm" id="newPassForm" class="form-control input-default " placeholder="Contraseña Nueva" />
      </div>
      <div class="form-group col-12 mt-3">
        <label for="confirmPassForm" class="form-label">Confirmar Contraseña</label>
        <input type="password" name="confirmPassForm" id="confirmPassForm" class="form-control input-default " placeholder="Confirmar Contraseña" />
      </div>
      
      <div id="respuesta" class="RespuestaAjax mt-3"></div> 
      <div class="d-flex flex-column align-items-center justify-content-center">
        <button class="btn btn-primary mx-auto" value="submit" name="submit" id="btn" type="submit">Ingresar</button>
      </div>
                    
    </form>
  </div>

  <?php include "./modulos/scripts.php"; ?>
  <script src="<?php echo media; ?>js/ajax/login.js"></script>
</body>

</html>
