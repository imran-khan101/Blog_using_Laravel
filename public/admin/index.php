<?php

require_once "../../includes/initialize.php";


if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

?>

<?php include_layout_template("admin_header.php") ?>
<!--<div class="container">
    <h2>Menu</h2>
    <?php /*echo output_message($session->message()); */?>
    <ul>
        <li><a href="logfile.php">View logs</a></li>
        <li><a href="photo_upload.php">Upload a photo</a></li>
        <li><a href="list_photos.php">View all photos</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>-->

<div class="jumbotron">
    <h1>Welcome to Basic Blog</h1>
    <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
    <p>
        <a class="btn btn-lg btn-primary" href="#" role="button">Welcome &raquo;</a>
    </p>
</div>

<?php include_layout_template("admin_footer.php") ?>

