<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    if (isset($_POST['id'])) {
        $id = trim(isset($_POST['id']));
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
    }
    $id = isset($_GET['id']) ? trim($_GET['id']) : null;

    if (!isset($id)) {
        header('Location: departamentos.php');
        return;
    }
    ?>
    <p>¿Está seguro de que quiere borrar ese departamento?</p>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit">Sí</button>
        <a href="departamentos.php">Volver</a>
    </form>
</body>
</html>
