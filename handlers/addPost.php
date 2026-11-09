<?php
session_start();
require_once "../inc/conn.php";
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

    $extensions = ['png', 'jpeg', 'jpg']; // PNG => png
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));


    if (empty($image['name'])) {
        $errors[] = "image is required";
    } else if (!in_array($ext, $extensions)) {
        $errors[] = "not valid extension... allowed png, jpeg, jpg";
    } else if ($image['size'] > 2 * pow(1024, 2)) { // 2MB => 2 * 1024 * 1024
        $errors[] = "image too Big | max 2 mb";
    }
    if (!empty($errors)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['errors'] = $errors;
        header('location: ../addPost.php');
        exit();
    }

    $imgName = uniqid() . "." . $ext;
    $user_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO posts (title, body, image, user_id)
            VALUES ('$title', '$body', '$imgName', $user_id)";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        move_uploaded_file($image['tmp_name'], "../assets/images/postImage/$imgName");
        $_SESSION['success'] = "Post Created Successfully";
        header('location: ../index.php');
        exit();
    } else {
        $_SESSION['errors'] = ['Add Post Failed'];
        header('location: ../addPost.php');
        exit();
    }
} else {
    header('location: ../addPost.php');
    exit();
}
