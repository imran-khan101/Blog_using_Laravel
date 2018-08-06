<?php
require_once "../../includes/initialize.php";

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['password'] == $_POST['confirm_password']) {
        $user = new User();
        $user->first_name = trim($_POST['first_name']);
        $user->last_name = trim($_POST['last_name']);
        $user->password = trim($_POST['password']);
        $user->email = trim($_POST['email']);
        $user->username = trim($_POST['username']);

        //check Database to see username/password exists
        $found_user = User::user_already_exists($user->username, $user->email);
        if (!$found_user) {
            $user->save();
            $session->login($user);
            redirect_to("index.php");
        } else {
            //username/password combo was not found in the database
            $message = "Username/Email already exists";
        }
    } else {
        $message = "password didn't match";
    }

} else {
    $username = "";
    $password = "";
    $message = "";
}

?>

<?php include_layout_template("admin_header.php") ?>
    <h2>Sign Up</h2>
    <!--Error message -->
<?php if ($message != ""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo output_message($message); ?>
    </div>
<?php endif; ?>
    <form action="sign_up.php" method="post">
        <div class="form-group">
            <label for="title">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="title">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Enter the password again:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required">
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Sign Up</button>
        </div>
    </form>
<?php include_layout_template("admin_footer.php") ?>