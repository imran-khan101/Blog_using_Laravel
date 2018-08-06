<?php
require_once LIB_PATH . DS . "database.php";
require_once LIB_PATH . DS . "session.php";
require_once LIB_PATH . DS . "function.php";

class Post extends DatabaseObject {
    protected static $table_name = "posts";
    protected static $db_fields = ['id', 'user_id', 'title', 'body', 'created_at'];

    public $id;
    public $user_id;
    public $title;
    public $body;
    public $created_at;

    //


    public function comments() {
        return Comment::find_comments_on($this->id, 0);
    }

    public function author() {
        return User::find_by_id($this->user_id)->full_name();
    }


}

