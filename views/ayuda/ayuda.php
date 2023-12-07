<?php 
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
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Ayuda | <?php echo NOMBRE;?></title>

    <meta name="description" content="" />

    <?php include "./modulos/links.php"; ?>

  </head>

  <body class="d-flex flex-column align-items-start bg-body" style="width: 100vw;">
    <?php include "./modulos/header.php"; ?>

    <div class="d-flex flex-row justify-content-between mb-0 ms-3 mt-3">
      <a class="btn btn-outline-primaty py-2 text-primary ml-4 nav-icon" href="./">
        <i class="bx bx-arrow-back text-primary"></i> Ir al Inicio
      </a>
    </div>

    <div class="card col-10 p-4 mx-auto mt-3" >
      <h4 id="index">Ayuda</h4>

      <div class="col-8 mx-auto my-5 d-flex flex-row justify-content-center flex-wrap">
        <h4 class="w-100">Contenido</h4>
        <a href="#login" class="text-primary m-3">Inicio de Sesión</a>
        <a href="#recover" class="text-primary m-3">Recuperar Contraseña</a>
        <a href="#inicio" class="text-primary m-3">Inicio</a>
        <a href="#inventario" class="text-primary m-3">Inventario</a>
        <a href="#historial" class="text-primary m-3">Historial</a>
        <a href="#ubicaciones" class="text-primary m-3">Ubicaciones</a>
        <a href="#reportes" class="text-primary m-3">Reportes</a>
        <a href="#configuraciones" class="text-primary m-3">Configuraciones</a>
      </div>

      <div class="col-12 mx-auto">

        <div class="mb-5">
          <h4 class="text-primary">Inicio</h4>
          <p>Bienvenido al sistema de Control de Transformadores instalados en el zona Carúpano - Paría. Esta sección te explicará el funcionamiento del sistema para evitar que tengas errores durante su uso.</p>
        </div>

        <div class="mb-5">
          <h4 id="login"><a class="text-primary" href="#login">Inicio de Sesión</a></h4>
          <div class="media">
            <img class="mr-3 img-fluid" src="<?php echo media; ?>img/screen-home.png" alt="Botón 'Iniciar Sesión'">
            <div class="media-body align-self-center">
              Si estás en la página de Bienvenida debes hacer click en el botón <strong>Iniciar Sesión</strong>.
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center">
              En la página de "Iniciar Sesión" veras dos campos "Nombre de Usuario" y "Contraseña".<br><br>Debes llenar ambos campos correctamente para iniciar la sesión con tus datos.<br><br>Una vez hayas llenado los campos haz click en el botón <strong>Entrar</strong> para iniciar tu sesión.
            </div>
            <img class="mr-3 img-fluid" src="<?php echo media; ?>img/screen-login.png" alt="Página de Inicio de Sesión">
          </div>
        </div>

        <div class="mb-5">
          <h4 id="recover"><a class="text-primary" href="#recover">Recuperar Contraseña</a></h4>
          <p>En caso de haber olvidado tu contraseña haz click en el enlace "¿Olvidaste tu Contraseña?", que puedes encontrar en la página de "Iniciar Sesión".</p>
          <div class="media mt-4">
            <img class="mr-3 img-fluid" src="<?php echo media; ?>img/screen-recover.png" alt="Recuperar Contraseña">
            <div class="media-body align-self-center">
              Dentro de la página de "Recuperar Contraseña" debes ingresar el correo que utilizaste para crear la cuenta y hace click en el botón <strong>Comprobar</strong>.
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center">
              Cuando ingreses el correo correcto serás llevado a la página de "Crear Nueva Contraseña" donde debes ingresar tu nueva contraseña.
            </div>
            <img class="mr-3 img-fluid" src="<?php echo media; ?>img/screen-newpass.png" alt="Recuperar Contraseña">
          </div>
          <p class="mt-5">Finalmente, en la página de "Iniciar Sesión" puede entrar en tu cuenta usando tu contraseña nueva.</p>
        </div>

        <div class="mb-5">
          <h4 id="inicio"><a class="text-primary" href="#inicio">Inicio</a></h4>
          <p>Al iniciar sesión serás llevado al "Inicio" donde recibiras información resumida del sistema en general, esta página incluye las siguientes características:</p>
          <div class="media mt-5">
            <img class="mr-5 img-fluid align-self-center" src="<?php echo media; ?>img/widget-menu.png" alt="Menú Principal">
            <div class="media-body">
              <h5 class="mt-0"><strong>Menú Principal</strong></h5>
              <p>En el Menú Principal se encuentran los enlaces a las páginas principales del sistema.</p>
              <ul class="list-icons">
                <li><i class="bx bx-chevron-right text-primary"></i> Inicio <small>(Información del sistema en general)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Inventario <small>(Contiene la información de los <strong>Transformadores</strong>)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Historial <small>(Contiene la información de las <strong>Operaciones</strong>)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Ubicaciones <small>(Contiene la información según las ubicaciones)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Reportes <small>(Reportes en PDF)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Configuraciones <small>(Incluye opciones para configurar las cuentas)</small>.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Cerrar Sesión <small>(Botón para cerrar la sesión)</small>.</li>
              </ul>
            </div>
          </div>
          <div class="media mt-4">
            <div class="media-body align-self-center col-7 mr-3">
              <h5 class="mt-0"><strong>Panel de Datos</strong></h5>
              También, puedes encontrar el Panel de Datos donde esta la información <br> resumida de los datos del sistema, como:
              <ul class="list-icons">
                <li><i class="bx bx-chevron-right text-primary"></i> Transformadores Instalados.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Transformadores Dañados.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Transformadores en Stock.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Capacidad Instalada.</li>
              </ul>
            </div>
            <div class="d-flex flex-column">
              <img class="img-fluid" src="<?php echo media; ?>img/widget-datos1.png" alt="Datos">
              <img class="img-fluid" src="<?php echo media; ?>img/widget-datos2.png" alt="Datos">
              <img class="img-fluid" src="<?php echo media; ?>img/widget-datos3.png" alt="Datos">
              <img class="img-fluid" src="<?php echo media; ?>img/widget-datos4.png" alt="Datos">
            </div>
          </div>
          <div class="media mt-5">
            <img class="mr-5 img-fluid w-65" src="<?php echo media; ?>img/widget-chart.png" alt="Gráfica">
            <div class="media-body align-self-center">
              <h5 class="mt-0"><strong>Distribución por Municipios</strong></h5>
              <p>La ventana de Distribución por Municipios muestra una gráfica de barras sencilla en la que se distingue la distribución de los transformadores "Instalados" y "Dañados" en los distintos municipios que abarcan la zona Carúpano-Paría.</p>
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center col-7 mr-3">
              <h5 class="mt-0"><strong>Historial de Operaciones</strong></h5>
              Finalmente, encontraras la ventana de Historial de Operaciones donde se encuentra una lista que contiene las últimas operaciones realizadas en el sistema, en cada objeto de la lista se identifica:
              <ul class="list-icons">
                <li><i class="bx bx-chevron-right text-primary"></i> Fecha en la que realizó la operación.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Procedimiento realizado.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> N° Serial del Transformados.</li>
              </ul>
            </div>
            <img class="img-fluid" src="<?php echo media; ?>img/widget-historial.png" alt="Historial">
          </div>
        </div>

        <div class="mb-5">
          <h4 id="inventario"><a class="text-primary" href="#inventario">Inventario</a></h4>
          <p>En la página de "Inventario" se encuentra toda la información referente a los transformadores, esta página cuenta con dos propiedades:</p>
          <div class="media mt-5">
            <img class="img-fluid mr-5 align-self-center" src="<?php echo media; ?>img/btn-addT.png" alt="Botón 'Añadir Transformador'">
            <div class="media-body">
              <h5 class="mt-0"><strong>Botón "Añadir Transformador"</strong></h5>
              Este botón despliega un panel en el cual es ingresada la información para registrar un transformador en el sistema.
            </div>
          </div>
          <img class="mx-auto mt-3 img-fluid" src="<?php echo media; ?>img/form-trans.png" alt="Formulario Añadir Transformador">
          <p>Una vez llenados todos los campos debe hacer click en <strong>Añadir Datos</strong> y el transformador se añadirá automaticamente a la Tabla de Transformadores.</p>
          
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Tabla de Transformadores</strong></h5>
              La Tabla de Transformadores muestra la información de todos los transformadores ingresados en el sistema, y cuenta con características como:
              <ul class="list-icons">
                <li><i class="bx bx-chevron-right text-primary"></i> Puede ordenarse haciendo click en los nombres de las columnas.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Se puede filtrar la información realizando búsquedas en el campo <strong>Buscar</strong> arriba a la derecha.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Los usuarios <strong>Administradores</strong> pueden ver la columna <strong>Acciones</strong> que les permite "Editar" y "Eliminar" la información.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Al hacer click en el número serial de un transformador será llevado a una página que contiene toda la información sobre ese transformador en específico.</li>
              </ul>
            </div>
          </div>
          <img class="img-fluid" src="<?php echo media; ?>img/widget-tablaT.png" alt="Tabla de Transformadores">
        </div>

        <div class="mb-5">
          <h4 id="historial"><a class="text-primary" href="#historial">Historial</a></h4>
          <p>La página "Historial" cuenta con las mismas funciones que la página "Inventario", pero estas están dirigidas a las operaciones que son realizadas en los transformadores, por ejemplo:</p>
          <ul class="list-icons">
            <li><i class="bx bx-chevron-right text-primary"></i> Reparación.</li>
            <li><i class="bx bx-chevron-right text-primary"></i> Almacenamiento.</li>
            <li><i class="bx bx-chevron-right text-primary"></i> Instalación.</li>
            <li><i class="bx bx-chevron-right text-primary"></i> Retiro.</li>
          </ul>
        </div>

        <div class="mb-5">
          <h4 id="ubicaciones"><a class="text-primary" href="#ubicaciones">Ubicaciones</a></h4>
          <p>La página de "Ubicaciones" contiene la información sobre los transformadores ordenada por los distintos municipios que abarcan de la zona Carúpano - Paría y la Central de Servicios.</p>
          <div class="media mt-5">
            <img class="img-fluid col-7" src="<?php echo media; ?>img/widget-ubicaciones-list.png" alt="Lista de Ubicaciones">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Lista de Ubicaciones</strong></h5>
              En este panel se muestran las distintas ubicaciones de la zona Carúpano - Paría, debes seleccionar una opción y presionar el botón <strong>Buscar</strong> para obtener la información.
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Panel de Información</strong></h5>
              Este panel se desplegará mostrando la información primero de manera general y luego de forma detallada en una tabla que cuenta con las mismas funcionalidades anteriores. 
            </div>
          </div>
          <img class="img-fluid mx-auto" src="<?php echo media; ?>img/widget-ubicaciones-info.png" alt="Información de Ubicaciones">
        </div>

        <div class="mb-5">
          <h4 id="reportes"><a class="text-primary" href="#reportes">Reportes</a></h4>
          <p>La página de "Reportes" permite generar reportes en formato PDF, estos pueden crearse de manera sencilla con los siguientes botones:</p>
          <img class="img-fluid mx-auto" src="<?php echo media; ?>img/widget-report-btn.png" alt="Botones de Reportes">
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Botón <strong>Reporte General</strong> </strong></h5>
              Al presionar este botón se abrirá una nueva ventana con un reporte general de toda la información almacenada en el sistema ordenada por municipios. 
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Botón <strong>Reporte Personalizado</strong> </strong></h5>
              <p>Este botón permite administrar la información que se incluirá en el reporte, al hacer click se desplegará un panel donde se pueden seleccionar las opciones y filtrar la información siguiendo los pasos:<br/></p>
              <ul class="list-icons">
                <li><i class="text-primary font-weight-bold mr-2">1</i> Selecciona un Tema, puedes elegir entre <strong>Transformadores</strong> y <strong>Operaciones</strong> <small>(Solo puedes elegir un Tema)</small>.</li>
                <li><i class="text-primary font-weight-bold mr-2">2</i> Si quieres que tu reporte cubra todas las Categorias disponibles del tema, solamente activa el Tema y deja en blanco las Categorias.</li>
                <li><i class="text-primary font-weight-bold mr-2">3</i> En caso de necesitar un reporte más específico, activa la categoría que necesites y selecciona una opción <small>(Asegurate de tener el Tema activado)</small>.</li>
                <li><i class="text-primary font-weight-bold mr-2">4</i> Una vez hayas escogidos las opciones que necesites haz click en el botón <strong>Generar</strong> y espera un momento mientras tu informe se generá en una nueva pestaña.</li>
                <li><i class="bx bx-chevron-right text-primary"></i> Si cometiste un error durante la selección de Temas y Categorias, haz click en el botón <strong>Limpiar</strong>.</li>
              </ul>
            </div>
          </div>
          <img class="img-fluid" src="<?php echo media; ?>img/widget-report-form.png" alt="Formulario de Reportes">
        </div>

        <div class="mb-5">
          <h4 id="configuraciones"><a class="text-primary" href="#configuraciones">Configuraciones</a></h4>
          <p>La página de "Configuraciones" te permitirá observar y editar la información de tu cuenta.</p>
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Panel de Perfil</strong></h5>
              En este panel se muestra la información del usuario actualmente activo. 
            </div>
          </div>
            <img class="img-fluid mr-3 mt-2" src="<?php echo media; ?>img/widget-perfil-ad.png" alt="Perfil">
          <div class="media mt-5 mx-auto">
            <img class="img-fluid mr-3" src="<?php echo media; ?>img/widget-perfil.png" alt="Enlace 'Editar Datos'">
            <div class="media-body align-self-center">
              <p>En caso de los usuarios <strong>Normales</strong> se mostrará un enlace para editar los datos.</p>
            </div>
          </div>
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Panel de Cuentas</strong></h5>
              Este panel solo está disponible a los usuarios <strong>Administradores</strong>, en el tienen las siguientes opciones:
            </div>

          </div>
          <img class="img-fluid mx-auto mt-2" src="<?php echo media; ?>img/widget-cuentas.png" alt="Tabla de Cuentas">
          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Añadir de Cuentas</strong></h5>
              Haciendo click en el botón <strong>Añadir Cuenta</strong> se desplegará un panel donde se podrán agregar los datos para crear una cuenta nueva.
            </div>
          </div>

          <div class="media mt-5">
            <div class="media-body align-self-center mr-3">
              <h5 class="mt-0"><strong>Tabla de Cuentas</strong></h5>
              También se muestra una tabla donde se podrán observar todas cuentas creadas en el sistema, así como editarlas y eliminarlas<br> <small>(La cuenta actualmente activa se mostrará en color azul)</small>.
            </div>
          </div>
        </div>
      </div>
    </div>

    <a href="#index" class="btn btn-outline-primary p-2 bg-white" style="position: fixed; bottom: 8%; right: 3%;"><i class="bx bx-chevron-up text-primary"></i></a>

    <?php include "./modulos/scripts.php"; ?>

  </body>
</html>
