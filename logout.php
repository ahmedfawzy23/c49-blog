<?php

session_start();
unset($_SESSION['user']);
unset($_SESSION['is_logged_in']);
header('location: index.php');
exit();
