<?php

require_once "../../includes/initialize.php";


if (!$session->is_logged_in()) {
    redirect_to("login.php");
}


//1. the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
//2. records per page
$per_page = 5;
//3. total record count
$total_count = Photograph::count_all_for_user(User::current_user()->id);


//find all photos
//use pagination instead
//$photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM photographs ";
$sql .= "WHERE user_id = '" . User::current_user()->id . "' ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
$photos = Photograph::find_by_sql($sql);

//Need to add ?page=$page to all links we want
//maintain the current page (or store in the session)

?>
<?php include_layout_template("admin_header.php") ?>
<a href="index.php">&laquo; Menu</a>
<h2>Madnage Photos</h2>
<?php echo output_message($session->message()); ?>
<table class="table table-bordered table-hover" border="1px" id="photoview">
    <tr>
        <th>Image</th>
        <th>Filename</th>
        <th>Caption</th>
        <th>Size</th>
        <th>Type</th>
        <th>Comments</th>
        <th>&nbsp;</th>
    </tr>
    <?php
    foreach ($photos as $photo) : ?>
        <tr>
            <td><img width="100" src="../<?php echo $photo->image_path() ?>"
                     alt="<?php echo $photo->filename ?>"><br></td>
            <td><?php echo $photo->filename; ?></td>
            <td><?php echo $photo->caption; ?></td>
            <td><?php echo $photo->size_as_text(); ?></td>
            <td><?php echo $photo->type; ?></td>
            <td><a href="comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()); ?></a></td>
            <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<div id="pagination" style="clear: both">
    <?php
    if ($pagination->total_page() > 1) {
        if ($pagination->previous_page()) {

            echo "<a href=\"manage_photos.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo;Previous</a>";
        }
        for ($i = 1; $i <= $pagination->total_page(); $i++) {
            if ($i == $page) {
                echo "<span class=\"selected\">{$i}</span>";
            } else {
                echo "&nbsp;<a href=\"manage_photos.php?page={$i}\">{$i} </a>&nbsp;";
            }

        }
        if ($pagination->has_next_page()) {

            echo " &nbsp;<a href=\"manage_photos.php?page=";
            echo $pagination->next_page();
            echo "\"> Next &raquo;</a>";
        }
    }
    ?>
</div>
<br>
<br>
<a href="photo_upload.php">Upload a new photo</a>
<?php include_layout_template("admin_footer.php") ?>

