<?php
session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $action = $_POST['action'];
    
    if ($action == 'like') {
        $user->like_post($post_id, $user->id);
    } elseif ($action == 'unlike') {
        $user->unlike_post($post_id, $user->id);
    }
    
    $like_count = $user->get_post_likes($post_id);
    $unlike_count = $user->get_post_unlikes($post_id);
    
    echo json_encode(['like_count' => $like_count, 'unlike_count' => $unlike_count]);
}
?>
