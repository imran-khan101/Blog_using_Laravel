<?php

require_once "../../includes/initialize.php";


if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (isset($_POST['submit'])) {
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);
    if ($photo->save()) {
        //Success
        $session->message("Photo Successfully saved");
        redirect_to('list_photographs.php');
    } else {
        //Failure
        $message = "Photo failed to upload <br>";
        $message .= join("<br>", $photo->error);

    }
}
?>
<?php $max_file_size = 1048576 //expressed in bytes ?>
<?php include_layout_template("admin_header.php") ?>
<div class="container">
    <h2>Photo Upload</h2>
    <a href="index.php">&laquo; Menu</a>
    <br>
    <br>
    <?php echo output_message($session->message); ?>
    <form action="photo_upload.php" method="post" enctype="multipart/form-data" class="">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <div class="form-group">
            <label for="title">File</label>
            <input type="file" class="form-control-file" name="file_upload" id="">
        </div>
        <div class="form-group">
            <label for="title">Caption</label>
            <input type="text" class="form-control" name="caption" id="">
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Publish</button>
        </div>
    </form>
</div>

<?php include_layout_template("admin_footer.php") ?>

