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
            <label for="name">Name</label>
            <input type="text" class="form-control" value="<?php print htmlentities($name) ?>" id="catName" name="name" placeholder="name category">
          </div>
          <input type="hidden" name="form-submitted" value="1" />
          <input type="hidden" name="id" value="<?php print htmlentities($id) ?>" />
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
</div>
      
<?php
    include 'view/template/footer.php';
?>
