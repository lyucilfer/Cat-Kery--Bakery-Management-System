<?php
function getUserId() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        header('location:home.php');
        exit;
    }
}


function getAdminId() {
    if (isset($_SESSION['admin_id'])) {
        return $_SESSION['admin_id'];
    } else {
        header('location:admin_login.php');
        exit;
    }
}
?> 