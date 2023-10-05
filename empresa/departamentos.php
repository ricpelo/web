<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : null;
    ?>
    <form action="" method="get">
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" value="<?= $codigo ?>">
        <button type="submit">Buscar</button>
    </form>
    <?php
    $sent = $pdo->prepare('SELECT COUNT(*)
                             FROM departamentos
                            WHERE codigo = :codigo');
    $sent->execute([':codigo' => $codigo]);
    $cantidad = $sent->fetchColumn();
    if ($cantidad == 0): ?>
        <h3>No se ha encontrado ese departamento.</h3>
    <?php else:
        $sent = $pdo->prepare('SELECT *
                                 FROM departamentos
                                WHERE codigo = :codigo');
        $sent->execute([':codigo' => $codigo]);
        ?>
        <br>
        <table border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
                <th>Localidad</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila): ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                        <td><?= $fila['localidad'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>
