<?php

if(isset($_SESSION['facebook_access_token']) &&
  !empty($_SESSION['facebook_access_token']) && 
  isset($_SESSION['facebook']) &&
  !empty($_SESSION['facebook']) ) : ?>
<div class="card card-register mx-auto mt-5">
  <div class="card-header">Dashboard</div>
  <div class="card-body">
    <p>You are now logged in with your Facebook Account</p>
    <p>Nice to have you here <?php echo $_SESSION['facebook']['name']?></p>
    <img src="<?php echo $_SESSION['facebook']['img_url']?>" alt="">
  </div>
</div>

<?php elseif(isset($_SESSION['heroku_access_token']) &&
            !empty($_SESSION['heroku_access_token']) &&
            isset($_SESSION['heroku']) && 
            !empty($_SESSION['heroku'])) :?>
<div class="card card-register mx-auto mt-5">
  <div class="card-header">Dashboard</div>
    <div class="card-body">
      <p>You are now logged in with your Heroku Account</p>
      <p>Nice to have you here <?php echo $_SESSION['heroku']['name']?></p>
      <p>Sorry..No profile picture with heroku :(</p>
    </div>
  </div>
</div>

<?php elseif(isset($_SESSION['github_access_token']) &&
            !empty($_SESSION['github_access_token']) && 
            isset($_SESSION['github']) &&
            !empty($_SESSION['github'])) :?>
<div class="card card-register mx-auto mt-5">
  <div class="card-header">Dashboard</div>
    <div class="card-body">
      <p>You are now logged in with your Github Account</p>
      <p>Nice to have you here <?php echo $_SESSION['github']['name']?></p>
      <img src="<?php echo $_SESSION['github']['img_url']?>" alt="" width="50px" height="50px">
    </div>
  </div>
</div>

<?php else : ?>
<div class="card card-register mx-auto mt-5">
  <div class="card-header">Dashboard</div>
  <div class="card-body">
    <p>You are now logged in with the form</p>
    <p>Nice to have you here <?php echo $_SESSION['user']['name']?></p>
  </div>
</div>
<?php endif ?>