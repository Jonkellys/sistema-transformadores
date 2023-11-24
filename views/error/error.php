<!DOCTYPE html>

<html
  lang="es"
  class="light-style"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Error 404</title>

    <meta name="description" content="" />

    <?php include "./modulos/links.php"; ?>


  </head>

  <body class="bg-body">
    <!-- Content -->

    <!-- Error -->
    <div class="login-form-bg pt-5">
            <div class="row justify-content-center">
                <div class="col-xl-6 card text-center pt-3 align-items-center">
                              <h2 class="mb-2 mx-2">Error <strong class="text-primary">404</strong> </h2>
        <p class="mb-2 mx-2">Oops! 😖 La Dirección de Url No Fue Encontrada.</p>
                                <img
                                  src="<?php echo media; ?>img/404-error.png"
                                  alt="page-misc-error-light"
                                  width="500"
                                  class="img-fluid m-4"
                                />
                </div>
        </div>
    </div>
    <!-- /Error -->

    <!-- / Content -->


    <?php include "./modulos/scripts.php"; ?>

  </body>
</html>
