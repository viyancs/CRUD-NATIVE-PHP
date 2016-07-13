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
            <label for="name">Nama</label>
            <input type="text" class="form-control" value="<?php print htmlentities($name) ?>"  name="name" placeholder="nama reporter">
          </div>
          <div class="form-group">
            <label for="name">Email</label>
            <input type="email" class="form-control" value="<?php print htmlentities($email) ?>" name="email" placeholder="email">
          </div>
          <div class="form-group">
            <label for="name">Alamat</label>
            <textarea class="form-control" name="alamat" rows="3"><?php print htmlentities($alamat) ?></textarea>
          </div>
          <input type="hidden" name="form-submitted" value="1" />
          <input type="hidden" name="id" value="<?php print htmlentities($id) ?>" />
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
</div>
      
<?php
    include 'view/template/footer.php';
?>
