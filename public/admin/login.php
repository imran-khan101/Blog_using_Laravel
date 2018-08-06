<?php
require_once "../../includes/initialize.php";

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //check Database to see username/password exists
    $found_user = User::authenticate($username, $password);
    if ($found_user) {
        $session->login($found_user);
        log_action("Login", "{$username} Logged in");
        redirect_to("index.php");
    } else {
        //username/password combo was not found in the database
        $message = "Username/password combination incorrect";
    }

} else {
    $username = "";
    $password = "";
    $message = "";
}

?>

<?php include_layout_template("admin_header.php") ?>
    <h2>login</h2>
<?php if ($message != ""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo output_message($message); ?>
    </div>
<?php endif; ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="title">Username</label>
            <input type="text" class="form-control" id="username" name="username"  required>
        </div>
        <div class="form-group">
            <label for="body">Password</label>
            <input type="password" class="form-control" id="password" name="password" required">
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
<?php include_layout_template("admin_footer.php") ?>