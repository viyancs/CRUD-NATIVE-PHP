<?php 
  $base_url = 'http://localhost/crud/';
  $base_url_index = 'http://localhost/crud/index.php?';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>
    <?php 
      if(isset($title)) { 
        echo htmlentities($title); 
      } 
    ?>
  </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $base_url ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Crud</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!--<ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="margin-top: 80px;">
          <ul class="nav nav-sidebar">
            <li><a href="<?php echo $base_url_index ?>&r=news">News</a></li>
            <li><a href="<?php echo $base_url_index ?>&r=reporter">Reporter</a></li>
            <li><a href="<?php echo $base_url_index ?>&r=categories">Categories</a></li>
          </ul>
        </div>