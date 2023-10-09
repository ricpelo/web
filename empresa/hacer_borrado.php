<?php
require 'auxiliar.php';

$id = isset($_POST['id']) ? trim($_POST['id']) : null;

if (!isset($id)) {
    return volver_departamentos();
}

if (!ctype_digit($id)) {
    return volver_departamentos();
}

$pdo = conectar();

$pdo->beginTransaction();
$sent = $pdo->prepare('SELECT * FROM departamentos WHERE id = :id FOR UPDATE');
$sent->execute([':id' => $id]);

if (buscar_departamento_por_id($id, $pdo) === false) {
    return volver_departamentos();
}

$sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
$sent->execute([':id' => $id]);

$pdo->commit();

volver_departamentos();
