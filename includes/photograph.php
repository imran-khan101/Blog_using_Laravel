<?php
require_once LIB_PATH . DS . "database.php";
require_once LIB_PATH . DS . "session.php";
require_once LIB_PATH . DS . "function.php";

class Photograph extends DatabaseObject {
    protected static $table_name = "photographs";
    protected static $db_fields = ['id', 'filename', 'user_id', 'type', 'size', 'caption'];

    public $id;
    public $filename;
    public $user_id;
    public $type;
    public $size;
    public $caption;
    //
    public $error = [];
    protected $upload_dir = "images";
    protected $upload_errors = [
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION => "File upload stopped by extension."
    ];
    private $temp_path;

    //Pass in $_FILE(['upload_file']) as an argument
    public function attach_file($file) {
        global $session;
        //perform error checking on the forms parameter
        if (!$file || empty($file) || !is_array($file)) {
            //Error: nothing uploaded or wrong argument given
            $this->error[] = "No file was uploaded";
            return false;
        } elseif ($file['error'] != 0) {
            //Error: report what PHP says went wrong
            $this->error[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            //Set object attributes to the form parameters
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename($file['name']);
            $this->user_id = $session->get_user_id();
            $this->type = $file['type'];
            $this->size = $file['size'];
            return true;
        }

        //Don't worry about saving anything to the database yet
    }

    public function size_as_text() {

        if ($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif ($this->size < 1048576) {
            return round($this->size / 1024) . " KB";
        } else {
            return round($this->size / 1048576, 1) . " MB";
        }
    }

    public function comments() {
        return Comment::find_comments_on(0,$this->id);
    }

    public function save() {
        //A new record wont have id yet
        if (isset($this->id)) {
            //Really just to update the caption
            $this->update();
        } else {
            //Make sure there are not errors

            //cant save if there are any pre existing error
            if (strlen($this->caption) > 255) {
                $this->error[] = "The caption can only be 255 characters long";
                return false;
            }

            //cant save without filename and temp location
            if (empty($this->filename) || empty($this->temp_path)) {
                $this->error[] = "The file location was not available";
                return false;
            }

            //Determining the target path
            $target_path = SITE_ROOT . DS . 'public' . DS . $this->upload_dir . DS . $this->filename;

            //Make sure the file isn't exist in the target location
            if (file_exists($target_path)) {
                $this->error[] = "The file {$this->filename} already exists .";
                return false;
            }

            //Attempt to move the file
            if (move_uploaded_file($this->temp_path, $target_path)) {
                //Success
                //Save corresponding entry to the Database
                if ($this->create()) {
                    //We are done with temp_path ,the file isn't there anymore
                    unset($this->temp_path);
                    return true;
                }
            } else {
                //File wasn't moved
                $this->error[] = "The file upload failed ,Possibly due to incorrect permission on the upload folder";
                return false;
            }
        }
    }

    //Wont work while debugging
    public function destroy() {
        //First remove the database entry
        if ($this->delete()) {
            //Then remove the file
            $target_path = SITE_ROOT . DS . 'public' . DS . $this->image_path();
            return unlink($target_path) ? true : false;
        } else {
            //Database delete failed
            return false;
        }

    }

    /*public function destroy() {
        $this->delete();
        $target_path = SITE_ROOT . DS . 'public' . DS . $this->image_path();
        log_action("error", $target_path);
        unlink($target_path);

    }*/

    public function image_path() {
        return $this->upload_dir . DS . $this->filename;
    }

}

