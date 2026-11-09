<?php

function old($key)
{

    $value = null;
    if (isset($_SESSION['old'][$key])) {
        $value = $_SESSION['old'][$key];
        unset($_SESSION['old'][$key]);
    }
    return $value;
}
