<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Departamentos</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    function mostrar_tabla(PDOStatement $sent)
    { ?>
        <table border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
                <th>Localidad</th>
                <th colspan="2">Acciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila): ?>
                    <tr>
                        <td><?= hh($fila['codigo']) ?></td>
                        <td><?= hh($fila['denominacion']) ?></td>
                        <td><?= hh($fila['localidad']) ?></td>
                        <td><a href="borrar.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                        <td><a href="modificar.php?id=<?= $fila['id'] ?>">Modificar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <a href="insertar.php">Insertar un nuevo departamento</a>

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

    $pdo = conectar();
    $codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';

    cabecera();

    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['exito'])) {
        echo $_SESSION['exito'];
        unset($_SESSION['exito']);
    }
    ?>

    <h1 class="text-3xl font-bold underline">
        Hello world!
    </h1>

    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <span class="font-medium">Info alert!</span> Change a few things up and try submitting again.
    </div>

    <form action="" method="get">
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" value="<?= $codigo ?>">
        <button type="submit">Buscar</button>
    </form>
    <br>
    <?php
    if ($codigo == '') {
        $sent = $pdo->query('SELECT * FROM departamentos ORDER BY codigo');
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
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
