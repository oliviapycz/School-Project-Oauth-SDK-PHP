<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OAUTH - SDK</title>

    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="public/css/sb-admin.css" rel="stylesheet">

    <link href="public/css/style.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <header class="container-fluid">
      <div class="row">
      <div class="col-3">
        <a class="btn btn-warning" href="<?php echo Routing::getSlug("Pages", "default") ?>"><h1>3IW2</h1></a>
      </div>
        <div class="col-6 text-center">
        <h1>OAUTH SDK - PROJECT</h1>
        </div>
        <div class="col-3">
          <?php if(isset($_SESSION['user']) || 
                   isset($_SESSION['facebook']) || 
                   isset($_SESSION['heroku']) || 
                   isset($_SESSION['github'])): ?>
          <div class="row">
            <a class="col-4 btn btn-info" href="<?php echo Routing::getSlug("Users", "logout") ?>">Logout</a>
          </div>
          <?php else : ?>
            <div class="row">
              <a class="col-4 btn btn-info" href="<?php echo Routing::getSlug("Users", "login") ?>">Login</a>
              <a class="offset-2 col-4 btn btn-info" href="<?php echo Routing::getSlug("Users", "add") ?>">Register</a>
            </div>
          <?php endif ?>
        </div>
      </div>
      
    </header>

    <main class="container">
      <?php include $this->view;?>
    </main>

    <!-- Bootstrap core JavaScript-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
