<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Departamentos</title>
</head>

<body>
    <?php
    require '../../src/auxiliar.php';

    function mostrar_tabla(PDOStatement $sent)
    { ?>
        <div class="mx-10 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="px-6 py-3">Código</th>
                    <th scope="col" class="px-6 py-3">Denominación</th>
                    <th scope="col" class="px-6 py-3">Localidad</th>
                    <th <th scope="col" class="px-6 py-3 text-center" colspan="2">Acciones</th>
                </thead>
                <tbody>
                    <?php foreach ($sent as $fila) : ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4"><?= hh($fila['codigo']) ?></td>
                            <td class="px-6 py-4"><?= hh($fila['denominacion']) ?></td>
                            <td class="px-6 py-4"><?= hh($fila['localidad']) ?></td>
                            <td class="px-6 py-4">
                                <a href="borrar.php?id=<?= $fila['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Borrar
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="modificar.php?id=<?= $fila['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Modificar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
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
    ?>

    <div class="container mx-auto">
        <?php require '../../src/_cabecera.php' ?>
        <?php require '../../src/_alerts.php' ?>

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
    </div>
    <script src="/js/flowbite/flowbite.min.js"></script>
</body>

</html>
