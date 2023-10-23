<?php
session_start();
$id = trim($_GET['id']);
$_SESSION['carrito'][] = $id;
header('Location: index.php');
