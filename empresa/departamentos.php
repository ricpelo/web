<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php
    function mostrar_tabla(PDOStatement $sent)
    { ?>
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
    <?php
    }

    function mostrar_error_departamento_no_existe()
    { ?>
        <h3>No se ha encontrado ese departamento.</h3>
    <?php
    }

    function cuantos_departamentos($codigo, $pdo)
    {
        $sent = $pdo->prepare('SELECT COUNT(*)
                                 FROM departamentos
                                WHERE codigo = :codigo');
        $sent->execute([':codigo' => $codigo]);
        return $sent->fetchColumn();
    }

    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';
    ?>
    <form action="" method="get">
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" value="<?= $codigo ?>">
        <button type="submit">Buscar</button>
    </form>
    <?php
    if ($codigo == '') {
        $sent = $pdo->query('SELECT * FROM departamentos');
        mostrar_tabla($sent);
    } else {
        if (cuantos_departamentos($codigo, $pdo) == 0) {
            mostrar_error_departamento_no_existe();
        } else {
            $sent = $pdo->prepare('SELECT *
                                     FROM departamentos
                                    WHERE codigo = :codigo');
            $sent->execute([':codigo' => $codigo]);
            mostrar_tabla($sent);
        }
    }
    ?>
</body>
</html>
