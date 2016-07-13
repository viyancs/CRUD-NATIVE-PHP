<?php
    include 'view/template/header.php';
?>

        <div class="col-sm-9 col-md-9  main" style="margin-top:80px;">
          
          <h2 class="sub-header">List Category</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <a class="btn btn-primary" href="<?php echo $base_url_index ?>&r=categories&op=create">create</a>
              <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><a href="<?php echo $base_url_index ?>r=categories&op=show&id=<?php print $cat->id; ?>"><?php print htmlentities($cat->id); ?></a></td>
                    <td><?php print htmlentities($cat->name); ?></td>
                    <td><?php print htmlentities($cat->status); ?></td>
                    <td>
                        <a class="btn btn-danger" href="<?php echo $base_url_index ?>r=categories&op=delete&id=<?php print $cat->id; ?>" onclick="return confirm('Are you sure?')">delete</a>
                        <a class="btn btn-warning" href="<?php echo $base_url_index ?>r=categories&op=update&id=<?php print $cat->id; ?>">update</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                
              </tbody>
            </table>
          </div>
        </div>
      
<?php
    include 'view/template/footer.php';
?>