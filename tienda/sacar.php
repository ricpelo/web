<?php
session_start();
$id = trim($_GET['id']);
foreach ($_SESSION['carrito'] as $k => $v) {
    if ($v == $id) {
        unset($_SESSION['carrito'][$k]);
        header('Location: index.php');
    }
}
header('Location: index.php');
