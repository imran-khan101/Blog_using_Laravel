<?php

class Session {
    public $user_id;
    public $message;
    private $logged_in = false;

    function __construct() {
        session_start();
        $this->check_login();
        $this->check_message();
    }

    private function check_login() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    private function check_message() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    public static function logged_in() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    public function login($user) {
        //Authentication will be done from database based on username/password
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    public function get_user_id() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }
    }

    public function message($msg = "") {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }
}

$session = new Session();
