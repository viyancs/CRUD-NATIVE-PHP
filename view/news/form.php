<?php
    include 'view/template/header.php';
?>

<div class="col-sm-9 col-md-9  main" style="margin-top:80px;">
        <?php
        if ( $errors ) {

            print '<div class="alert alert-danger" role="alert">';
            foreach ( $errors as $field => $error ) {
                print '<strong>Oh snap!</strong> '.htmlentities($error);
            }
            print '</div>';
        }
        ?>

        <form method="POST" action="">
          <div class="form-group">
            <label for="name">Author</label>
            <select class="form-control" name="author"> 
              <option value="">Select Reporter</option> 
              <?php foreach ($listReporter as $rep): ?>
              <option <?php if ($rep->id == $author) { echo 'selected'; } ?> value="<?php print htmlentities($rep->id); ?>"><?php print htmlentities($rep->nama); ?></option> 
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Category</label>
            <select class="form-control" name="cat"> 
              <option value="">Pilih Category</option> 
              <?php foreach ($listCategory as $cat): ?>
              <option  <?php if ($cat->id == $ct_id) { echo 'selected'; } ?>  value="<?php print htmlentities($cat->id); ?>"><?php print htmlentities($cat->name); ?></option> 
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Title</label>
            <input type="text" class="form-control" value="<?php print htmlentities($title) ?>" name="title" placeholder="title">
          </div>
          <div class="form-group">
            <label for="name">content</label>
            <textarea class="form-control" name="content" id="editor" rows="3"><?php print htmlentities($content) ?></textarea>
          </div>
          <input type="hidden" name="form-submitted" value="1" />
          <input type="hidden" name="id" value="<?php print htmlentities($id) ?>" />
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
</div>
      
<?php
    include 'view/template/footer.php';
?>
