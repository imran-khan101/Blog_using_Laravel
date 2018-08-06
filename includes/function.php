<?php

function strip_zeros_from_date($marked_string = "") {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function output_message($message = "") {
    if (!empty($message)) {
        return "<p class=\"message\">{$message}</p>";
    } else {
        return "";
    }
}

/*function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH . DS . "{$class_name}.php";
    if (file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}*/

function include_layout_template($template = "") {
    include(SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}

function log_action($action, $message = "") {
    chdir(SITE_ROOT . DS . "logs/");
    $txt = strftime('%m/%d/%Y %H:%M:%S', time()) . "|" . $action . " " . $message;
    if (!is_log_file_exists()) {
        create_new_log_file();
        file_put_contents('log_file.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
    } else {
        file_put_contents('log_file.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

}

function is_log_file_exists() {
    $dir = "../logs";
    if (is_dir($dir)) {
        return file_exists($dir . "/log_file.txt") ? true : false;
    }
}

function create_new_log_file() {
    chdir("../logs");
    $file = 'log_file.txt';
    if ($handle = fopen($file, 'w')) {
        $content = "Log file created in : " . strftime('%m/%d/%Y %H:%M:%S', time()) . "\n";
        fwrite($handle, $content);
        fclose($handle);
    }
}

function datetime_to_text($datetime) {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d,%Y at %I:%M %p", $unixdatetime);
}

function password_encrypt($password)
{

    $hash_format = "$2y$10$"; //Telss PHP to use Blowfish with a "cost" of 10
    $salt_lenght = 22; //Blowfish salt should be 22-Characters or more

    $salt = generate_salt($salt_lenght);
    $format_and_salt = $hash_format . $salt;

    $hash = crypt($password, $format_and_salt);
    echo "<br>";
    return $hash;
}

function generate_salt($lenght)
{
    //Not 100% unique, not 100% random, but good enough for a salt
    //MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));

    // Valid Character salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    //But not '+' which is valid in base64 ecnoding
    $modified_based64_string = str_replace("+", '.', $base64_string);

    //Truncate string to the correct length
    $salt = substr($modified_based64_string, 0, $lenght);

    return $salt;
}

function password_check($password, $existing_hash)
{
    //existing_hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash == $existing_hash) {
        return true;
    } else {
        return false;
    }
}

function attempt_login($username, $password)
{
    $admin = find_admin_by_username($username);
    if ($admin) {
        //found admin , now check password
        if (password_check($password, $admin['hashed_password'])) {
            return $admin;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

