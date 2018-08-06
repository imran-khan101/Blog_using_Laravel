<?php
require_once "../../includes/initialize.php";
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
?>

<?php
if (empty($_GET['id'])) {
    $session->message("No comment ID was Provided .");
    redirect_to('index.php');
}
$comment = Comment::find_by_id($_GET['id']);
//Wont work while debugging
if ($comment && $comment->delete()) {
    $session->message("The comment was deleted .");
    redirect_to("comments.php?id={$comment->photograph_id}");
} else {
    $session->message("The comment couldn't be deleted .");
    redirect_to("comments.php?id={$comment->photograph_id}");
}

?>
<?php if (isset($database)) {
    $database->close_connection();
} ?>