<?php

require_once "../../includes/initialize.php" ;


//1. the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
//2. records per page
$per_page = 3;
//3. total record count
$total_count = Post::count_all();


//find all photos
//use pagination instead
//$photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM posts ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
$posts = Post::find_by_sql($sql);

//Need to add ?page=$page to all links we want
//maintain the current page (or store in the session)

?>
<?php include_layout_template("admin_header.php") ?>
<div class="container">

    <?php echo output_message($session->message()); ?>
    <?php echo output_message(isset($_COOKIE['message'])); ?>
    <?php
    foreach ($posts as $post) : ?>
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><a
                            href="post.php?id=<?php echo $post->id; ?>""><?php echo $post->title; ?></a></h2>
                <p class="blog-post-meta">  <?php echo datetime_to_text($post->created_at); ?> by <a
                            href="#"><?php echo $post->author(); ?></a>
                </p>
                <p><?php echo $post->body; ?></p>
            </div>
        </div><!-- /.blog-main -->
    <?php endforeach; ?>
    <div id="pagination" style="clear: both">
        <?php
        if ($pagination->total_page() > 1) {
            if ($pagination->previous_page()) {

                echo "<a href=\"view_all_post.php?page=";
                echo $pagination->previous_page();
                echo "\">&laquo;Previous</a>";
            }
            for ($i = 1; $i <= $pagination->total_page(); $i++) {
                if ($i == $page) {
                    echo "<span class=\"selected\">{$i}</span>";
                } else {
                    echo "&nbsp;<a href=\"view_all_post.php?page={$i}\">{$i} </a>&nbsp;";
                }

            }
            if ($pagination->has_next_page()) {

                echo " &nbsp;<a href=\"view_all_post.php?page=";
                echo $pagination->next_page();
                echo "\"> Next &raquo;</a>";
            }
        }
        ?>
    </div>
</div>
<?php include_layout_template("footer.php") ?>

