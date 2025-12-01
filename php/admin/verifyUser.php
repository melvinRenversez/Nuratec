<?php 

if (!isset($_SESSION['admin_id'])) {
    session_destroy();
    header("Location: ../admin/index.php");
    exit();
}