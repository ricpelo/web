<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    if (isset($_POST['id'])) {
        $id = trim($_POST['id']);
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

        $sent = $pdo->prepare('SELECT COUNT(*)
                                 FROM empleados
                                WHERE departamento_id = :departamento_id');
        $sent->execute([':departamento_id' => $id]);

        if ($sent->fetchColumn() != 0) {
            return volver_departamentos();
        }

        $sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
        $sent->execute([':id' => $id]);

        $pdo->commit();

        volver_departamentos();
    }
    if (isset($_GET['id'])) {
        $id = trim($_GET['id']);
    }

    if (!isset($id)) {
        return volver_departamentos();
    }
    ?>
    <p>¿Está seguro de que quiere borrar ese departamento?</p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit">Sí</button>
        <a href="/departamentos/index.php">Volver</a>
    </form>
</body>
</html>
