<?php
require_once "../../includes/initialize.php" ;

if (!$session->is_logged_in()) {
    redirect_to("admin/login.php");
}
//1. the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
//2. records per page
$per_page = 3;
//3. total record count
$total_count = Photograph::count_all();


//find all photos
//use pagination instead
//$photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
$photos = Photograph::find_by_sql($sql);

//Need to add ?page=$page to all links we want
//maintain the current page (or store in the session)

?>
<?php include_layout_template("admin_header.php") ?>
<h2>Photo View</h2>
<?php echo output_message($session->message()); ?>
<?php echo output_message(isset($_COOKIE['message'])); ?>
<?php
foreach ($photos as $photo) : ?>
    <div style="float: left;margin-left: 20px">
        <a href="photo.php?id=<?php echo $photo->id; ?>">
            <img width="200" src="../<?php echo $photo->image_path() ?>"
                 alt="<?php echo $photo->filename ?>">
        </a>
        <p><?php echo $photo->caption; ?></p>
    </div>
<?php endforeach; ?>
<div id="pagination" style="clear: both">
    <?php
    if ($pagination->total_page() > 1) {
        if ($pagination->previous_page()) {

            echo "<a href=\"list_photographs.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo;Previous</a>";
        }
        for ($i = 1; $i <= $pagination->total_page(); $i++) {
            if ($i == $page) {
                echo "<span class=\"selected\">{$i}</span>";
            } else {
                echo "&nbsp;<a href=\"list_photographs.php?page={$i}\">{$i} </a>&nbsp;";
            }

        }
        if ($pagination->has_next_page()) {

            echo " &nbsp;<a href=\"list_photographs.php?page=";
            echo $pagination->next_page();
            echo "\"> Next &raquo;</a>";
        }
    }
    ?>
</div>
<?php include_layout_template("footer.php") ?>

