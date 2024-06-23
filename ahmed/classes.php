<?php 

abstract class User{

    function __construct($id,$name,$email,$password,$phone,$image,$created_at,$updated_at,$banned) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->banned = $banned;

    }

    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    protected $password;
    public $created_at;
    public $updated_at;
    public $banned;


    public static function login($email,$password){

        $user = null;
        $qry = "SELECT * FROM USERS WHERE email = '$email' AND password = '$password'";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        if($arr = mysqli_fetch_assoc($rslt)){
            switch ($arr["role"]) {
                case 'subscriber':
                    $user = new Subscriber($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["image"],$arr["created_at"],$arr["updated_at"],$arr["banned"]);
                    break;
                case 'admin':
                    $user = new Admin($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["image"],$arr["created_at"],$arr["updated_at"],$arr["banned"]);
                    break;
            }
        }
        mysqli_close($cn);
        return $user;
    }
    public function store_post($title,$content,$imageName,$user_id){
        $qry = "INSERT INTO POSTS (title,content,image,user_id) values('$title','$content','$imageName',$user_id)";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function store_comment($comment,$post_id,$user_id){
        $qry = "INSERT INTO comments (comment,post_id,user_id) values('$comment',$post_id,$user_id)";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function myposts($user_id){
        $qry = "SELECT * FROM POSTS WHERE USER_ID = $user_id ORDER BY created_at DESC";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function homePosts(){
        $qry = "SELECT * FROM users inner join posts on posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 10";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function homePosts1(){
        $qry = "SELECT * FROM posts inner join users on posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 10";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    public function update_profile_pic($imagePath,$user_id){
        $qry = "UPDATE USERS SET IMAGE = '$imagePath' WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function get_post_comment($post_id){
        $qry = "SELECT * FROM USERS join COMMENTS on comments.user_id = users.id WHERE POST_ID = $post_id ORDER BY comments.created_at DESC";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }
    function Delete_post($id){
        $qry = "DELETE FROM POSTS WHERE id = $id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }    
    function Delete_comment($id){
        $qry = "DELETE FROM COMMENTS WHERE id = $id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function like_post($post_id, $user_id) {
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        
        $delete_unlike_query = "DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id AND action = 'unlike'";
        mysqli_query($cn, $delete_unlike_query);
        
        $check_query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = $post_id AND user_id = $user_id AND action = 'like'";
        $check_result = mysqli_query($cn, $check_query);
        $check_data = mysqli_fetch_assoc($check_result);
        
        if ($check_data['count'] == 0) {
            $insert_query = "INSERT INTO post_likes (post_id, user_id, action) VALUES ($post_id, $user_id, 'like')";
            mysqli_query($cn, $insert_query);
        }
        
        mysqli_close($cn);
    }
    
    public function unlike_post($post_id, $user_id) {
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        
        $delete_like_query = "DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id AND action = 'like'";
        mysqli_query($cn, $delete_like_query);
        
        $check_query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = $post_id AND user_id = $user_id AND action = 'unlike'";
        $check_result = mysqli_query($cn, $check_query);
        $check_data = mysqli_fetch_assoc($check_result);
        
        if ($check_data['count'] == 0) {
            $insert_query = "INSERT INTO post_likes (post_id, user_id, action) VALUES ($post_id, $user_id, 'unlike')";
            mysqli_query($cn, $insert_query);
        }
        
        mysqli_close($cn);
    }
    
public function get_post_likes($post_id) {
    require_once("config.php");
    $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
    
    $qry = "SELECT COUNT(*) as like_count FROM post_likes WHERE post_id = $post_id AND action = 'like'";
    $rslt = mysqli_query($cn, $qry);
    $data = mysqli_fetch_assoc($rslt);
    
    mysqli_close($cn);
    
    return $data['like_count'];
}

public function get_post_unlikes($post_id) {
    require_once("config.php");
    $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
    
    $qry = "SELECT COUNT(*) as unlike_count FROM post_likes WHERE post_id = $post_id AND action = 'unlike'";
    $rslt = mysqli_query($cn, $qry);
    $data = mysqli_fetch_assoc($rslt);
    
    mysqli_close($cn);
    
    return $data['unlike_count'];
}

    public function like_comment($comment_id) {
        $qry = "INSERT INTO comment_likes (comment_id, user_id) VALUES ($comment_id, $this->id)";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function unlike_comment($comment_id) {
        $qry = "DELETE FROM comment_likes WHERE comment_id = $comment_id AND user_id = $this->id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function get_comment_likes($comment_id) {
        $qry = "SELECT COUNT(*) as like_count FROM comment_likes WHERE comment_id = $comment_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_assoc($rslt);
        mysqli_close($cn);
        return $data['like_count'];
    }
}
class Subscriber extends User{
    public $role = "subscriber";

    public static function register($name,$email,$password,$phone){
        $qry = "INSERT INTO USERS(name,email,password,phone)
        VALUES('$name','$email','$password','$phone')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
}

class Admin extends User{
    public $role = "admin";

    function get_all_users(){
        $qry = "SELECT * FROM USERS ORDER BY CREATED_AT";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

    function get_all_posts(){
        $qry = "SELECT * FROM POSTS ORDER BY CREATED_AT";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

    function get_all_comments(){
        $qry = "SELECT * FROM COMMENTS ORDER BY CREATED_AT";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rslt,MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

    function Delete_Account($user_id){
        $qry = "DELETE FROM USERS WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }

    function ban_user($user_id) {
        $qry = "UPDATE USERS SET banned = 1 WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    function deleteban_user($user_id) {
        $qry = "UPDATE USERS SET banned = 0 WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    function make_admin($user_id) {
        $qry = "UPDATE USERS SET role = 'admin' WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
    function make_subscriber($user_id) {
        $qry = "UPDATE USERS SET role = 'subscriber' WHERE id = $user_id";
        require_once("config.php");
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
}
