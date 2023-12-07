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
?>

<!DOCTYPE html>
<html lang="en">

<?php
  include "./conexiones/funciones.php"; 
  $codigo = strClean($_GET['serial']);
  $sql = connect()->prepare("SELECT * FROM transformadores WHERE T_Codigo = '$codigo'");
  $sql->execute();
  $data = $sql->fetch(PDO::FETCH_OBJ);
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include "./modulos/links.php"; ?>
  <title>Transformador <?php echo $codigo; ?> | <?php echo NOMBRE; ?></title>
</head>

<body style="width: 100vw;">
  <?php include "./modulos/menu.php"; ?>

  <div class="d-flex flex-row justify-content-between mb-4 ms-3">
    <a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="inventario">
      <i class="bx bx-arrow-back text-primary"></i> Volver
    </a>
  </div>

  <div class="container-fluid mt-0 flex-grow-1 container-p-y ml-5 card col-9 mx-auto p-4">
    <h4 class="fw-bold mb-0">Transformador <?php echo $codigo; ?></h4>

    <ul class="list-group mt-3 mb-3">
      <li class="list-group-item"><strong>N° Serial:  </strong><?php echo $data->T_Codigo; ?></li>
      <li class="list-group-item"><strong>Capacidad:  </strong><?php echo $data->T_Capacidad; ?> w</li>
      <li class="list-group-item"><strong>Tipo:  </strong><?php echo $data->T_Tipo; ?></li>
      <li class="list-group-item"><strong>Banco Transformador:  </strong><?php echo $data->T_Banco; ?></li>
      <li class="list-group-item"><strong>Ubicación:  </strong><?php echo $data->T_Municipio; ?></li>
      <li class="list-group-item"><strong>Estado Actual:  </strong><?php echo $data->T_Estado; ?></li>
      <li class="list-group-item"><strong>Dirección:  </strong><?php echo $data->T_Direccion; ?></li>
    </ul>


    <?php
        $direccion = $data->T_Direccion;
        $code = $data->T_Codigo;

      if($data->T_Banco == "Sí") {
        $stmt = connect()->query("SELECT * FROM transformadores WHERE T_Direccion = '$direccion' AND T_Banco = 'Sí' AND T_Codigo != '$code'");
        
        echo '<h4 class="fw-bold mb-3 mt-4">Banco Transformador junto con</h4>
            <ul class="mb-3">
        ';

        while ($rows = $stmt->fetch()) {
          echo '
            <li class="list-group-item mb-2"><strong>N° Serial:  </strong><a class="text-primary" href="transformador?serial=' . $rows['T_Codigo'] . '">' . $rows['T_Codigo'] . '</li>
          </a>';
        }

        echo '</ul>';
      }

      $operacionesQuery = connect()->query("SELECT * FROM operaciones WHERE O_Equipo = '$code'");
      if($operacionesQuery->rowCount() >= 1) {
        echo '<h4 class="fw-bold mb-3 mt-4">Operaciones realizadas en este transformador</h4>
          <ul class="mb-3">
        ';

        while ($row = $operacionesQuery->fetch()) {
          echo '
            <li class="list-group-item mb-2"><strong>Procedimiento:  </strong>' . $row['O_Procedimiento'] . '<strong class="ml-5">Fecha:  </strong>' . $row['O_Fecha'] . '</li>
          </a>';
        }

        echo '
            </ul>
          </div>
        ';
      } else {
        echo '</div>';
      }
    ?>
  </div>

  <?php include "./modulos/scripts.php"; ?>
</body>

</html>
