<?php
require_once "../../includes/initialize.php";
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
?>

<?php
if (empty($_GET['id'])) {
    $session->message("No post ID was Provided .");
    redirect_to('index.php');
}
$post = Post::find_by_id($_GET['id']);
//Wont work while debugging
if ($post && $post->delete()) {
    $session->message("The post was deleted .");
    redirect_to('view_all_post.php');
} else {
    $session->message("The photo couldn't be deleted .");
    redirect_to('view_all_post.php');
}

?>
<?php if (isset($database)) {
    $database->close_connection();
} ?>