<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Borrar departamento</title>
</head>
<body>
    <?php
    require '../../src/auxiliar.php';

    if (isset($_POST['id'])) {
        $id = trim($_POST['id']);
        if (!ctype_digit($id)) {
            return volver_departamentos();
        }

        if (!validar_csrf()) {
            return volver_departamentos();
        }

        $pdo = conectar();

        $pdo->beginTransaction();
        $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id = :id FOR UPDATE');
        $sent->execute([':id' => $id]);
        if (buscar_departamento_por_id($id, $pdo) === false) {
            return volver_departamentos();
        }

        $sent = $pdo->prepare('SELECT COUNT(*)
                                 FROM empleados
                                WHERE departamento_id = :departamento_id');
        $sent->execute([':departamento_id' => $id]);

        if ($sent->fetchColumn() != 0) {
            $_SESSION['error'] = 'El departamento tiene empleados';
            return volver_departamentos();
        }

        $sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
        $sent->execute([':id' => $id]);

        $pdo->commit();

        $_SESSION['exito'] = 'El departamento se ha borrado correctamente';
        return volver_departamentos();
    }

    if (isset($_GET['id'])) {
        $id = trim($_GET['id']);
    }

    if (!isset($id)) {
        return volver_departamentos();
    }

    require '../../src/_cabecera.php';
    ?>
    <p>¿Está seguro de que quiere borrar ese departamento?</p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <?php campo_csrf() ?>
        <button type="submit">Sí</button>
        <a href="/departamentos/index.php">Volver</a>
    </form>
    <script src="/js/flowbite/flowbite.min.js"></script>
</body>
</html>
