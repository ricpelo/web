<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    const PARS = [
        'numero' => null,
        'nombre' => null,
        'apellidos' => null,
        'salario' => null,
        'fecha_alta' => null,
        'departamento_id' => null,
    ];

    extract(PARS);

    $pdo = conectar();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $isset = true;
        foreach (PARS as $par => $valor) {
            $$par = obtener_post($par);
            if ($$par === null) {
                $isset = false;
            }
        }

        if ($isset) {
            // Validar datos de entrada
            $errores = [];
            // comprobar_codigo($codigo, $errores, $pdo);
            // comprobar_denominacion($denominacion, $errores);
            // comprobar_localidad($localidad, $errores);
            // Hacer la inserción
            if (empty($errores)) {
                // Insertar
                $columnas = implode(', ', array_keys(PARS));
                $marcadores = ':' . implode(', :', array_keys(PARS));
                $sent = $pdo->prepare("INSERT INTO empleados ($columnas)
                                       VALUES ($marcadores)");
                $execute = [];
                foreach (PARS as $par => $valor) {
                    $execute[$par] = $$par;
                }
                $sent->execute($execute);
                // Volver
                return volver_empleados();
            }
        }
    }
    ?>
    <?php if (!empty($errores)): ?>
        <ul>
        <?php foreach ($errores as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
        </ul>
    <?php endif ?>

    <?php
    $sent = $pdo->query('SELECT * FROM departamentos ORDER BY codigo');
    ?>

    <form action="" method="post">
        <label for="numero">Número</label>
        <input type="text" name="numero" id="numero"
               value="<?= $numero ?>"><br>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre"
               value="<?= $nombre?>"><br>
        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" id="apellidos"
               value="<?= $apellidos ?>"><br>
        <label for="salario">Salario</label>
        <input type="text" name="salario" id="salario"
               value="<?= $salario ?>"><br>
        <label for="fecha_alta">Fecha de alta</label>
        <input type="text" name="fecha_alta" id="fecha_alta"
               value="<?= $fecha_alta?>"><br>
        <label for="departamento_id">Departamento</label>
        <select name="departamento_id" id="departamento_id">
            <?php foreach ($sent as $departamento): ?>
                <option value="<?= $departamento['id'] ?>">
                    <?= "({$departamento['codigo']}) {$departamento['denominacion']}" ?>
                </option>
            <?php endforeach ?>
        </select><br>
        <button type="submit">Insertar</button>
        <a href="/departamentos/index.php">Cancelar</a>
    </form>
</body>
</html>
