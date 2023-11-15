<?php
  date_default_timezone_set("America/Caracas");

  session_start(['name' => 'Sistema']);

  $page = "busqueda";

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
  <title>Búsqueda | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">

  <?php include "./modulos/menu.php"; ?>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-3">
    <h4 class="fw-bold mb-0">Búsqueda</h4>
  </div>

  <div class="container-fluid p-4">

    <div class="card col-9 mx-auto p-3">
      <h4>Realiza una búsqueda</h4>
      <form action="<?php echo SERVERURL; ?>controllers/busqueda.php" autocomplete="off" enctype="multipart/form-data" method="POST" data-form="save" class="FormularioAjax p-3">
        <div class="input-group mb-3 col-11 mx-auto mt-2">
          <input type="text" class="form-control rounded-left" name="" placeholder="Buscar">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Buscar</button>
          </div>
        </div>
                          <div id="respuesta" class="RespuestaAjax mt-3"></div> 

      </form>
    </div>


    <div class="col-lg-11 mx-auto card">
          <div class="card-body">
              <div class="card-title">
                  <h4>Table Striped</h4>
              </div>
              <div class="table-responsive">
                  <table class="table table-striped table-hover">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Price</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <th>1</th>
                              <td>Kolor Tea Shirt For Man</td>
                              <td><span class="badge badge-primary px-2">Sale</span>
                              </td>
                              <td>January 22</td>
                              <td class="color-primary">$21.56</td>
                          </tr>
                          <tr>
                              <th>2</th>
                              <td>Kolor Tea Shirt For Women</td>
                              <td><span class="badge badge-danger px-2">Tax</span>
                              </td>
                              <td>January 30</td>
                              <td class="color-success">$55.32</td>
                          </tr>
                          <tr>
                              <th>3</th>
                              <td>Blue Backpack For Baby</td>
                              <td><span class="badge badge-success px-2">Extended</span>
                              </td>
                              <td>January 25</td>
                              <td class="color-danger">$14.85</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

  </div>

  <?php include "./modulos/scripts.php"; ?>
<script src="<?php echo media; ?>js/ajax/principal.js"></script>

</body>

</html>
