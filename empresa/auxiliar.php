<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

function buscar_departamento_por_id($id, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }

    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id = :id');
    $sent->execute([':id' => $id]);
    return $sent->fetch();
}

function volver_departamentos()
{
    header('Location: departamentos.php');
}

function obtener_post(string $par): ?string
{
    return isset($_POST[$par]) ? trim($_POST[$par]) : null;
}
