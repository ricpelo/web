<?php
require 'auxiliar.php';

$id = isset($_POST['id']) ? trim($_POST['id']) : null;

if (!isset($id)) {
    header('Location: departamentos.php');
    return;
}

if (!ctype_digit($id)) {
    header('Location: departamentos.php');
    return;
}

$pdo = conectar();

$pdo->beginTransaction();
$sent = $pdo->prepare('SELECT * FROM departamentos WHERE id = :id FOR UPDATE');
$sent->execute([':id' => $id]);

if (buscar_departamento_por_id($id, $pdo) === false) {
    header('Location: departamentos.php');
    return;
}

$sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
$sent->execute([':id' => $id]);

$pdo->commit();

header('Location: departamentos.php');
