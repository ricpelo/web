<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar departamento</title>
</head>
<body>
    <?php
    $id = isset($_GET['id']) ? trim($_GET['id']) : null;

    if (!isset($id)) {
        header('Location: departamentos.php');
        return;
    }
    ?>
    <p>¿Está seguro de que quiere borrar ese departamento?</p>
    <form action="hacer_borrado.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit">Sí</button>
        <a href="departamentos.php">Volver</a>
    </form>
</body>
</html>
