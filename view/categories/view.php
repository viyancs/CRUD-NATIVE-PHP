<?php
    include 'view/template/header.php';
?>

  <div class="col-sm-9 col-md-9  main" style="margin-top:80px">

    <dl class="dl-horizontal"> 
      <dt>Name</dt> 
      <dd><?php echo $category->name; ?></dd> 
      <dt>Status</dt> 
      <dd><?php echo $category->status; ?></dd> 
      <dt>Created At</dt> 
      <dd><?php echo $category->created_at; ?></dd> 
      <dt>Updated At</dt> 
      <dd><?php echo $category->updated_at; ?></dd> 
    </dl>
  </div>
      
<?php
    include 'view/template/footer.php';
?>