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

function comprobar_codigo($codigo, &$errores)
{
    if ($codigo == '') {
        $errores[] = 'El código no puede ser vacío';
        return;
    }
    if (mb_strlen($codigo > 2)) {
        $errores[] = 'El código es demasiado largo';
    }
    if (!ctype_digit($codigo)) {
        $errores[] = 'El código tiene un formato incorrecto';
    }
}
