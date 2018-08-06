<?php
require_once "../../includes/initialize.php";


if (!$session->is_logged_in()) {
    redirect_to("index.php");
}
if (empty($_GET['id'])) {
    $session->message("No post were selected.");
    redirect_to('view_all_post.php');
}

$post = Post::find_by_id($_GET['id']);
if (!$post) {
    $session->message("No photograph was found.");
    redirect_to('view_all_post.php');
}

if (isset($_POST['submit'])) {
    $user_id = trim($_POST['user_id']);
    $body = trim($_POST['body']);

    $new_comment = Comment::make($post->id, null, $user_id, $body);
    if ($new_comment && $new_comment->save()) {
        //Comment save
        //No message needed;seeing the comment is proof enough
        /*$new_comment->try_to_send_notification();*/
        /*Important! You could just render the [age from here
         *But then if the phone is reloaded ,the form will try
         * to re submit the comment ,redirect instead;
         * */
        redirect_to("post.php?id={$post->id}");
    } else {
        //Failed
    }
} else {
    //$author = "";
    $body = "";
}
$comments = $post->comments();
?>

<?php include_layout_template('admin_header.php'); ?>

<a href="index.php">&laquo; Back</a> <br>
<br>

<div class="col-sm-8 blog-main">
    <div class="blog-post">
        <h2 class="blog-post-title"><?php echo $post->title; ?></h2>
        <p class="blog-post-meta">  <?php echo datetime_to_text($post->created_at); ?> by <a
                    href="#"><?php echo $post->author() ?></a>
        </p>
        <p><?php echo $post->body; ?></p>
    </div>
</div><!-- /.blog-main -->

<!--list comment-->
<div id="comments">
    <?php foreach ($comments as $comment): ?>
        <div class='container'>
            <div class="col-sm-7 blog-main">
                <div class="media comment-box">
                    <div class="media-left">
                        <a href="#">
                            <img class="img-responsive user-photo"
                                 src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="#"><?php echo htmlentities($comment->author()); ?></a></h4>
                        <p><strong><?php echo htmlentities($comment->created); ?></strong> <br>
                            <?php echo strip_tags($comment->body, '<strong><em><p>') //allow users to use this tag?>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($comments)) {
        echo "No comments";
    } ?>
</div>
<hr>
<div class="">
    <h3>New Comment</h3>
    <?php echo output_message($session->message) ?>
    <form action="post.php?id=<?php echo $post->id; ?>" method="post">
        <input type="hidden" name="user_id" value="<?php echo User::current_user()->id ?>">
        <div class="form-group">
            <label for="title">Your Comment here:</label>
            <textarea class="form-control" name="body" id="" cols="10" rows="5"><?php echo $body; ?></textarea>
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Submit comment</button>
        </div>
    </form>
</div>

<?php include_layout_template('admin_footer.php'); ?>
