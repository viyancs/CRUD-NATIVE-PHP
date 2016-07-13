<?php
    include 'view/template/header.php';
?>

  <div class="col-sm-9 col-md-9  main" style="margin-top:80px">

    <dl class="dl-horizontal"> 
      <dt>Name</dt> 
      <dd><?php echo $reporter->nama; ?></dd> 
      <dt>email</dt> 
      <dd><?php echo $reporter->email; ?></dd> 
      <dt>Alamat</dt> 
      <dd><?php echo $reporter->alamat; ?></dd> 
      <dt>Created At</dt> 
      <dd><?php echo $reporter->created_at; ?></dd> 
      <dt>Updated At</dt> 
      <dd><?php echo $reporter->updated_at; ?></dd> 
    </dl>
  </div>
      
<?php
    include 'view/template/footer.php';
?>