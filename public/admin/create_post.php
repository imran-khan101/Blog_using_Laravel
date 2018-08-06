<?php require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$message = "";
if (isset($_POST['submit'])) {
    $post = new Post();
    $post->title = $_POST['title'];
    $post->user_id = User::current_user()->id;
    $post->created_at = strftime("%Y-%m-%d %H:%M:%S", time());
    $post->body = $_POST['body'];
    if ($post->save()) {
        //Success
        $session->message("Post successfully saved");
        redirect_to('view_all_post.php');
    } else {
        //Failure
        $message = "Post failed to upload <br>";
    }
} ?>

<?php include_layout_template("admin_header.php"); ?>
<div class="col-sm-8 blog-main">
    <h1>Create a Post</h1>
    <hr>
    <?php echo $message ?>
    <form method="POST" action="create_post.php">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" name="body" id="" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Publish</button>
        </div>
    </form>
</div>
<?php include_layout_template("admin_footer.php") ?>
