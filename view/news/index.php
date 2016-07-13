<?php
    include 'view/template/header.php';
?>

        <div class="col-sm-9 col-md-9  main" style="margin-top:80px;">
          
          <h2 class="sub-header">List News</h2>
          <div class="table-responsive">
            <a class="btn btn-primary" href="<?php echo $base_url_index ?>&r=news&op=create">create</a>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Author</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th></th>
                </tr>
              </thead>
             
              <tbody>
                <?php foreach ($news as $nc): ?>
                <tr>
                    <td><a href="<?php echo $base_url_index ?>r=news&op=show&id=<?php print $nc->id; ?>"><?php print htmlentities($nc->id); ?></a></td>
                    <td><?php print htmlentities($nc->author_name); ?></td>
                    <td><?php print htmlentities($nc->title); ?></td>
                    <td><?php print htmlentities($nc->category_name); ?></td>
                    <td>
                        <a class="btn btn-danger" href="<?php echo $base_url_index ?>r=news&op=delete&id=<?php print $nc->id; ?>" onclick="return confirm('Are you sure?')">delete</a>
                        <a class="btn btn-warning" href="<?php echo $base_url_index ?>r=news&op=update&id=<?php print $nc->id; ?>">update</a>
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