<?php
    include 'view/template/header.php';
?>

  <div class="col-sm-9 col-md-9  main" style="margin-top:80px">

    <dl class="dl-horizontal"> 
      <dt>Author</dt> 
      <dd><?php echo $news->author_name; ?></dd> 
      <dt>Category</dt> 
      <dd><?php echo $news->category_name; ?></dd> 
      <dt>Title</dt> 
      <dd><?php echo $news->title; ?></dd> 
      <dt>Content</dt> 
      <dd><?php echo $news->content; ?></dd> 
      <dt>Created At</dt> 
      <dd><?php echo $news->created_at; ?></dd> 
      <dt>Updated At</dt> 
      <dd><?php echo $news->updated_at; ?></dd> 
    </dl>
  </div>
      
<?php
    include 'view/template/footer.php';
?>