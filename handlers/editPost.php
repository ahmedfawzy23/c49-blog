<?php
session_start();
require_once '../inc/conn.php';


$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    header('location: ' . $redirect);
    exit;
}

$sql = "SELECT * FROM posts where id = $id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);


if (empty($post)) {
    header('location: ../404.html');
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));
    $image = $_FILES['image'];


    $errors = [];
    if (empty($title)) {
        $errors[] = "Title is required";
    } else if (strlen($title) < 3 || strlen($title) > 50) {
        $errors[] = "Title must be between 3 and 50";
    }

    if (empty($body)) {
        $errors[] = "body is required";
    } else if (strlen($body) < 3 || strlen($body) > 3000) {
        $errors[] = "body must be between 3 and 50";
    }


    $imgName = $post['image'];

    if (!empty($image['name'])) {
        $extensions = ['png', 'jpeg', 'jpg']; // PNG => png
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $extensions)) {
            $errors[] = "not valid extension... allowed png, jpeg, jpg";
        } else if ($image['size'] > 2 * pow(1024, 2)) { // 2MB => 2 * 1024 * 1024
            $errors[] = "image too Big | max 2 mb";
        }

        $imgName = uniqid() . "." . $ext;
    }

    if (!empty($errors)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['errors'] = $errors;
        header("location: ../editPost.php?id=$id");
        exit();
    }


    $sql = "UPDATE posts SET title = '$title' , body = '$body', image = '$imgName'
            WHERE id = $id";


    $result = mysqli_query($conn, $sql);

    if ($result) {

        if (!empty($image['name'])) {
            move_uploaded_file($image['tmp_name'], "../assets/images/postImage/$imgName");
        }

        $_SESSION['success'] = "Post Updated Successfully";
        header('location: ../index.php');
        exit();
    } else {
        $_SESSION['errors'] = ['Update Post Failed'];
        header("location: ../editPost.php?id=$id");
        exit();
    }
} else {
    header("location: ../editPost.php?id=$id");
    exit();
}
