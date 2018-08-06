<?php require_once "../../includes/initialize.php" ?>
<?php

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

if (empty($_GET['id'])) {
    $session->message("No comments were selected.");
    redirect_to('index.php');
}

$post = Post::find_by_id($_GET['id']);
if (!$post) {
    $session->message("No post was found.");
    redirect_to('index.php');
}

/*if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $new_comment = Comment::make($photo->id, $author, $body);
    if ($new_comment && $new_comment->save()) {
        //Comment save
        //No message needed;seeing the comment is proof enough

        //Important! You could just render the [age from here
        //But then if the phone is reloaded ,the form will try
        //to re submit the comment ,redirect instead.
        redirect_to("photo.php?id={$photo->id}");
    } else {
        //Failed
    }
} else {
    $author = "";
    $body = "";
}*/


$comments = $post->comments();
?>

<?php include_layout_template('admin_header.php'); ?>

<br>

<div style="margin-left: 2px;">
    <h2>Comments on : <?php echo $post->title; ?></h2>
    <p><?php echo $post->body; ?></p>
</div>
<!--list comment-->
<?php echo output_message($session->message) ?>
<div id="comments">
    <?php foreach ($comments as $comment): ?>
        <div class="comment" style="margin-bottom: 2em">
            <div class="author">
                <?php echo htmlentities($comment->author()); ?> wrote:
            </div>
            <div class="body">
                <?php echo strip_tags($comment->body, '<strong><em><p>') //allow users to use this tag?>
            </div>
            <div class="meta-info" style="font-size: 0.8em">
                <?php echo datetime_to_text($comment->created); ?>
            </div>
            <div class="actions" style="font-size: 0.8em; ">
                <a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete comment</a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($comments)) {
        echo "No comments";
    } ?>
</div>

<?php include_layout_template('admin_footer.php'); ?>
