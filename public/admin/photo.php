<?php
require_once "../../includes/initialize.php" ;


if (!$session->is_logged_in()) {
    redirect_to("index.php");
}
if (empty($_GET['id'])) {
    $session->message("No photograph were selected.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if (!$photo) {
    $session->message("No photograph was found.");
    redirect_to('index.php');
}

if (isset($_POST['submit'])) {
    $user_id = trim($_POST['user_id']);
    $body = trim($_POST['body']);

    $new_comment = Comment::make(null, $photo->id, $user_id, $body);//no post_id
    if ($new_comment && $new_comment->save()) {
        redirect_to("photo.php?id={$photo->id}");
    } else {
        //Failed
    }
} else {
    //$author = "";
    $body = "";
}
$comments = $photo->comments();
?>

<?php include_layout_template("admin_header.php") ?>

<a href="index.php">&laquo; Back</a> <br>
<br>

<div style="margin-left: 2px;">
    <img src="../<?php echo $photo->image_path(); ?>" alt="">
    <p><?php echo $photo->caption; ?></p>
</div>
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
                        <p><strong><?php echo datetime_to_text($comment->created); ?></strong> <br>
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
    <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
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
<!--<div id="comment-form">
    <h3>New Comment</h3>
    <?php /*echo output_message($session->message) */?>
    <form action="photo.php?id=<?php /*echo $photo->id; */?>" method="post">
        <table>
            <input type="hidden" name="user_id" value="<?php /*echo User::current_user()->id */?>">
            <td>Your Comment:</td>
            <td><textarea name="body" id="" cols="30" rows="10"><?php /*echo $body; */?></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Submit comment" name="submit"></td>
            </tr>
        </table>
    </form>
</div>-->
<?php include_layout_template('footer.php'); ?>
