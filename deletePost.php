<?php
session_start();
require_once 'inc/conn.php';


$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header('location: ' . $redirect);
    exit;
}

$sql = "SELECT * FROM posts where id = $id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);


if (empty($post)) {
    header('location: 404.html');
    exit;
}

$sql = "DELETE FROM posts WHERE id = $id";

$result = mysqli_query($conn, $sql);
if ($result) {
    unlink("assets/images/postImage/{$post['image']}");
    $_SESSION['success'] = "Post Deleted Successfully";
    header('location: index.php');
    exit();
} else {
    $_SESSION['errors'] = ['Delete Post Failed'];
    header("location: viewPost.php?id=$id");
    exit();
}
