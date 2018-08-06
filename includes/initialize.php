<?php

defined("DS") ? null : define('DS', DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define('SITE_ROOT', "F:" . DS . "Programs" . DS . "PHP" . DS . "PhpOOP" . DS . "Basic-blog"); //we already configured the path by xampp config
defined("LIB_PATH") ? null : define('LIB_PATH', SITE_ROOT . DS . "includes");
defined("IMAGE_PATH") ? null : define('IMAGE_PATH', SITE_ROOT . DS . "public".DS."images");

//Load config file first
require_once LIB_PATH . DS . "config.php";
//Load basic functions next so that everything after that can use them
require_once LIB_PATH . DS . "function.php";
//Load core objects
require_once LIB_PATH . DS . "session.php";
require_once LIB_PATH . DS . "database.php";
require_once LIB_PATH . DS . "database_object.php";
require_once LIB_PATH . DS . "pagination.php";

//load database related object
require_once LIB_PATH . DS . "user.php";
require_once LIB_PATH . DS . "photograph.php";
require_once LIB_PATH . DS . "comment.php";
require_once LIB_PATH . DS . "post.php";
