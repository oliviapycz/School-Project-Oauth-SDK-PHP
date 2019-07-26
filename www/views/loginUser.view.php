<div class="row mt-5">
  <div class="col-5 text-center">
    <div class="card card-login">
      <div class="card-header">Login</div>
      <div class="card-body">
      <?php $this->addModal("form", $configFormLogin) ?>
      </div>
    </div>
  </div>

  <div class="offset-2 col-5 text-center">
    <div class="card card-login">
      <div class="card-header">Login with</div>
      <div class="card-body">
        
          <a class="btn btn-info btn-block" href="<?php echo Routing::getSlug("Provider", "login", ['provider' => 'Facebook']) ?>">Login with Facebook</a>
          <a class="btn btn-info btn-block" href="<?php echo Routing::getSlug("Provider", "login", ['provider' => 'Github']) ?>">Login with Github</a>
          <a class="btn btn-info btn-block" href="<?php echo Routing::getSlug("Provider", "login", ['provider' => 'Heroku']) ?>">Login with Heroku</a>
      </div>
    </div>
  </div>
</div>
