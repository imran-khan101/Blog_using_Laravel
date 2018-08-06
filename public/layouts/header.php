<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Basic Blog</title>
    <link rel="stylesheet" href="stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheets/blog.css">
    <link rel="stylesheet" href="stylesheets/comment.css">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="javascripts/bootstrap.js"></script>
</head>
<body>
<div class="container">
    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Basic Blog</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="admin/index.php">Home</a></li>
                    <!--<li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>-->
                    <?php if (Session::logged_in()): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">Post <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="view_all_post.php">Posts</a></li>
                                <li><a href="admin/create_post.php">Create a new Post</a></li>
                                <li><a href="#">Manage Post</a></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">Photos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="list_photographs.php">View All photos</a></li>
                                <li><a href="admin/photo_upload.php">Upload Photo</a></li>
                                <li><a href="#">Manage Post</a></li>

                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (Session::logged_in()):  ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><?php echo User::current_user()->full_name() ?></a></li>
                    <li><a href="../admin/logout.php">Logout</a></li>
                </ul>

                <?php endif;  ?>

            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <!--<div class="jumbotron">
        <h1>Navbar example</h1>
        <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>
            <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p>
    </div>-->
