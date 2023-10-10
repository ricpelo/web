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
    if (mb_strlen($codigo) > 2) {
        $errores[] = 'El código es demasiado largo';
    }
    if (!ctype_digit($codigo)) {
        $errores[] = 'El código tiene un formato incorrecto';
    }
    if (empty($errores)) {
        $pdo = conectar();
        $sent = $pdo->prepare('SELECT COUNT(*)
                                 FROM departamentos
                                WHERE codigo = :codigo');
        $sent->execute([':codigo' => $codigo]);
        $cantidad = $sent->fetchColumn();
        if ($cantidad > 0) {
            $errores[] = 'Ya existe un departamento con ese código';
        }
    }
}

function comprobar_denominacion($denominacion, &$errores)
{
    if ($denominacion == '') {
        $errores[] = 'La denominación no puede ser vacía';
        return;
    }
    if (mb_strlen($denominacion) > 255) {
        $errores[] = 'La denominación es demasiado larga';
    }
}

function comprobar_localidad($localidad, &$errores)
{
    if (mb_strlen($localidad) > 255) {
        $errores[] = 'La localidad es demasiado larga';
    }
}
