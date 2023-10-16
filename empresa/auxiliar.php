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

function buscar_departamento_por_codigo($codigo, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }

    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE codigo = :codigo');
    $sent->execute([':codigo' => $codigo]);
    return $sent->fetch();
}

function volver_departamentos()
{
    header('Location: /departamentos/index.php');
}

function volver_empleados()
{
    header('Location: /empleados/index.php');
}

function obtener_post(string $par): ?string
{
    return isset($_POST[$par]) ? trim($_POST[$par]) : null;
}

function comprobar_codigo($codigo, &$errores, ?PDO $pdo = null, $id = null)
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
        $departamento = buscar_departamento_por_codigo($codigo, $pdo);
        if ($departamento) {
            if ($id == null || ($id != null && $departamento['id'] != $id)) {
                $errores[] = 'Ya existe un departamento con ese código';
            }
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

function comprobar_localidad(&$localidad, &$errores)
{
    if (mb_strlen($localidad) > 255) {
        $errores[] = 'La localidad es demasiado larga';
    }

    if ($localidad == '') {
        $localidad = null;
    }
}
