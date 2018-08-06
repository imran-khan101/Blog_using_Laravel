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
$total_count = Post::count_all();


//find all photos
//use pagination instead
//$photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM posts ";
$sql .= "WHERE user_id = '" . User::current_user()->id . "' ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
$posts = Post::find_by_sql($sql);

//Need to add ?page=$page to all links we want
//maintain the current page (or store in the session)

?>
<?php include_layout_template("admin_header.php") ?>
<a href="index.php">&laquo; Menu</a>
<h2>Madnage Post</h2>
<?php echo output_message($session->message()); ?>
<table class="table table-bordered table-hover" border="1px" id="photoview">
    <tr>
        <th>Title</th>
        <th>body</th>
        <th>Created</th>
        <th>Comments</th>
        <th>&nbsp;</th>
    </tr>
    <?php
    foreach ($posts as $post) : ?>
        <tr>
            <td><strong><?php echo $post->title; ?></strong></td>
            <td><?php echo $post->body; ?></td>
            <td><?php echo datetime_to_text($post->created_at); ?></td>
            <td><a href="post_comments.php?id=<?php echo $post->id; ?>"><?php echo count($post->comments()); ?></a></td>
            <td><a href="delete_post.php?id=<?php echo $post->id; ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<div id="pagination" style="clear: both">
    <?php
    if ($pagination->total_page() > 1) {
        if ($pagination->previous_page()) {

            echo "<a href=\"manage_post.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo;Previous</a>";
        }
        for ($i = 1; $i <= $pagination->total_page(); $i++) {
            if ($i == $page) {
                echo "<span class=\"selected\">{$i}</span>";
            } else {
                echo "&nbsp;<a href=\"manage_post.php?page={$i}\">{$i} </a>&nbsp;";
            }

        }
        if ($pagination->has_next_page()) {

            echo " &nbsp;<a href=\"manage_post.php?page=";
            echo $pagination->next_page();
            echo "\"> Next &raquo;</a>";
        }
    }
    ?>
</div>
<?php include_layout_template("admin_footer.php") ?>

