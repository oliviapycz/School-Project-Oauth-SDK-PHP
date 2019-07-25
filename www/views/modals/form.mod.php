<?php
  // permet de laisser les champs remplis si rafraichissement de la page
  $data = ($config['config']['method'] == "POST")? $_POST: $_GET;
?>

<?php if(isset($config['errors'])):?>
  <div class="alert alert-danger">
  <?php foreach ($config['errors'] as $error):?>
    <li><?php echo $error;?></li>
  <?php endforeach;?>
  </div>
<?php endif;?>

<form method="<?php echo $config['config']['method'];?>"
      action="<?php echo $config['config']['action'];?>"
      id="<?php echo $config['config']['id'];?>"
      class="<?php echo $config['config']['class'];?>">
  
  <?php foreach ($config['data'] as $key => $value):?>
    <?php if($value["type"]=="text" || $value["type"]=="email" || $value["type"]=="password"):?>
      <?php if($value["type"] =="password") unset($data[$key]);?>
      <div class="form-group">
        <input type="<?php echo $value["type"];?>"
              name="<?php echo $key;?>"
              placeholder="<?php echo $value["placeholder"];?>"
              class="<?php echo $value["class"];?>"
              id="<?php echo $value["id"];?>"
              <?php echo ($value["required"])?'required="required"': '';?>
              value="<?php echo $data[$key]??'' ?>">
      </div>
    <?php endif;?>
  <?php endforeach?>

  <input type="submit" class="btn btn-info btn-block" value="<?php echo $config['config']['submit'];?>">
  <?php if(!empty($config['config']['reset'])):?>
   <input type="reset" class="btn btn-warning btn-block" value="<?php echo $config['config']['reset'];?>">
  <?php endif;?>
</form>