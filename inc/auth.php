<?php
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('location: index.php');
    exit();
}
