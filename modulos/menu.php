<?php 

  function menuDash($name) {
    if($name == "dashboard") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="dashboard"  class="btn btn-primary p-2 mr-1"';
    }
  }

  function menuInv($name) {
    if($name == "inventario") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="inventario"  class="btn btn-primary p-2 mr-1"';
    }
  }

  function menuHis($name) {
    if($name == "historial") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="historial"  class="btn btn-primary p-2 mr-1"';
    }
  }

  function menuUbic($name) {
    if($name == "ubicaciones") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="ubicaciones"  class="btn btn-primary p-2 mr-1"';
    }
  }
  
  function menuFile($name) {
    if($name == "reportes") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="reportes"  class="btn btn-primary p-2 mr-1"';
    }
  }

  function menuConf($name) {
    if($name == "configuraciones") {
      echo 'class="btn disabled p-2 mr-1"';
    } 
    else {
      echo 'href="configuraciones"  class="btn btn-primary p-2 mr-1"';
    }
  }
?>

<div class="app-header card rounded-0 bg-primary">    
  <div class="d-flex flex-row justify-content-between">  
    <div class="header-left">
      <div class="btn-group mt-2 mb-2 btn-group-lg">
        <a <?php menuDash($page) ?> data-toggle="tooltip" data-placement="bottom" title="Inicio"><i class="bx bx-home text-white font-medium"></i></a>
        <a <?php menuInv($page) ?> data-toggle="tooltip" data-placement="bottom" title="Inventario"><i class="bx bx-list-ul text-white font-medium"></i></a>
        <a <?php menuHis($page) ?> data-toggle="tooltip" data-placement="bottom" title="Historial"><i class="bx bx-time text-white font-medium"></i></a>
        <a <?php menuUbic($page) ?> data-toggle="tooltip" data-placement="bottom" title="Ubicaciones"><i class="bx bx-map text-white font-medium"></i></a>
        <a <?php menuFile($page) ?> data-toggle="tooltip" data-placement="bottom" title="Reportes"><i class="bx bx-file text-white font-medium"></i></a>
        <a <?php menuConf($page) ?> data-toggle="tooltip" data-placement="bottom" title="Configuraciones"><i class="bx bx-cog text-white font-medium"></i></a>
      </div>
    </div>

    <div class="header-right mr-4 m-out">
      
      <span data-toggle="tooltip" class="nav-icon col-1 rounded p-2 logoutBtn" data-placement="bottom" title="Cerrar Sesión" data-original-title="Cerrar Sesión"><i class="bx bx-log-out text-white font-medium answer"></i></span>
    </div>
  </div>
</div>
