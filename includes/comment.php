<?php
require_once LIB_PATH . DS . 'database.php';


class Comment extends DatabaseObject {
    protected static $table_name = "comments";
    protected static $db_fields = ['id', 'photograph_id', 'post_id', 'created', 'user_id', 'body'];

    public $id;
    public $photograph_id;
    public $post_id;
    public $created;
    public $user_id;
    public $body;

    public static function make($post_id = 0, $photo_id = 0, $user_id, $body) {
        if (!empty($user_id) && !empty($body)) {
            $comment = new Comment();
            $comment->photograph_id = $photo_id;
            $comment->post_id = $post_id;
            $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $comment->user_id = $user_id;
            $comment->body = $body;
            return $comment;

        } else {
            return false;
        }

    }

    public static function find_comments_on($post_id = 0, $photo_id = 0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        if ($photo_id != 0) {
            $sql .= " WHERE photograph_id=" . $database->escape_value($photo_id);
        }
        if ($post_id != 0) {
            $sql .= " WHERE post_id=" . $database->escape_value($post_id);
        }
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }

    public function author() {
        return User::find_by_id($this->user_id)->full_name();
    }

    /*   public function try_to_send_notification() {

       //require 'PHPMailer/vendor/autoload.php';
       $mail = new PHPMailer;
       $mail->isSMTP();
       $mail->SMTPDebug = 1;
       $mail->Host = 'smtp.gmail.com';
       $mail->Port = 587;

   //Set the encryption system to use - ssl (deprecated) or tls
       $mail->SMTPSecure = 'tls';

   //Whether to use SMTP authentication
       $mail->SMTPAuth = true;

   //Username to use for SMTP authentication - use full email address for gmail
       $mail->Username = "bodovaiimran@gmail.com";

   //Password to use for SMTP authentication
       $mail->Password = "borovaiimran";

   //Set who the message is to be sent from
       $mail->setFrom('bodovaiimran@gmail.com', 'Imran Khan');

   //Set an alternative reply-to address
   //$mail->addReplyTo('replyto@example.com', 'First Last');

   //Set who the message is to be sent to
       $mail->addAddress('imran.14k@live.com', 'Imran');

   //Set the subject line
       $mail->Subject = 'PHPMailer GMail SMTP test';

   //Read an HTML message body from an external file, convert referenced images to embedded,
   //convert HTML into a basic plain-text alternative body


       $mail->msgHTML(file_get_contents('template.html'), __DIR__ . DS . 'PHPMailer' . DS . 'passion' . DS);

   //Replace the plain text body with one created manually
   //$mail->AltBody = 'This is a plain-text message body';

   //Attach an image file
   //$mail->addAttachment('images/phpmailer_mini.png');

   //send the message, check for errors
       if (!$mail->send()) {
           $_COOKIE['message'] = "Mailer Error: " . $mail->ErrorInfo;
       } else {
           echo "Message sent!";
           //Section 2: IMAP
           //Uncomment these to save your message in the 'Sent Mail' folder.
           #if (save_mail($mail)) {
           #    echo "Message saved!";
           #}
       }
   }*/

}

?>