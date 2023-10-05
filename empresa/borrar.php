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
    <?= $id ?>
</body>
</html>
