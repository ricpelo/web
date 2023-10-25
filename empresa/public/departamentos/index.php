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
        <?php cabecera() ?>

        <?php if (isset($_SESSION['error'])) : ?>
            <div id="alert-2" class="border border-red-500 rounded-lg flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
                    <?= $_SESSION['error'] ?>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <?php unset($_SESSION['error']) ?>
        <?php endif ?>

        <?php
        if (isset($_SESSION['exito'])) {
            echo $_SESSION['exito'];
            unset($_SESSION['exito']);
        }
        ?>

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
