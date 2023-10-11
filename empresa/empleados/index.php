<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    function mostrar_tabla(PDOStatement $sent)
    { ?>
        <table border="1">
        <thead>
            <th>Número</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Salario</th>
            <th>Fecha de alta</th>
            <th>Departamento</th>
            <th colspan="2">Acciones</th>
        </thead>
        <tbody>
            <?php
            $fmt = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
            ?>
            <?php foreach ($sent as $fila): ?>
                <?php
                $salario = isset($fila['salario'])
                            ? $fmt->formatCurrency($fila['salario'], 'EUR')
                            : '';
                ?>
                <tr>
                    <td><?= $fila['numero'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['apellidos'] ?></td>
                    <td><?= $salario ?></td>
                    <td><?= (new DateTime($fila['fecha_alta']))->format('d-m-Y') ?></td>
                    <td><?= "({$fila['codigo']}) {$fila['denominacion']}" ?></td>
                    <td><a href="borrar.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                    <td><a href="modificar.php?id=<?= $fila['id'] ?>">Modificar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <a href="insertar.php">Insertar un nuevo empleado</a>

    <?php
    }

    function mostrar_error_empleado_no_existe()
    { ?>
        <h3>No se ha encontrado ese empleado.</h3>
    <?php
    }

    function cuantos_empleados($numero, $pdo)
    {
        $sent = $pdo->prepare('SELECT COUNT(*)
                                 FROM empleados
                                WHERE numero = :numero');
        $sent->execute([':numero' => $numero]);
        return $sent->fetchColumn();
    }

    $pdo = conectar();
    $numero = isset($_GET['numero']) ? trim($_GET['numero']) : '';
    ?>
    <form action="" method="get">
        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" value="<?= $numero ?>">
        <button type="submit">Buscar</button>
    </form>
    <br>
    <?php
    if ($numero == '') {
        $sent = $pdo->query('SELECT e.*, codigo, denominacion
                               FROM empleados e
                               JOIN departamentos d
                                 ON e.departamento_id = d.id
                           ORDER BY numero');
        mostrar_tabla($sent);
    } else {
        if (cuantos_empleados($numero, $pdo) == 0) {
            mostrar_error_empleado_no_existe();
        } else {
            $sent = $pdo->prepare('SELECT *
                                     FROM empleados
                                    WHERE numero = :numero');
            $sent->execute([':numero' => $numero]);
            mostrar_tabla($sent);
        }
    }
    ?>
</body>
</html>
