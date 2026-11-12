<?php


$lang = $_GET['lang'] ?? 'ar';


setcookie('lang', $lang, time() + 86400 * 30, '/');

header('location: ' . $_SERVER['HTTP_REFERER'] ?? 'index.php');
exit();
