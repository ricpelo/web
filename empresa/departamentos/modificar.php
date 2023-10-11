<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un departamento</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    if (!isset($_GET['id'])) {
        return volver_departamentos();
    }

    $id = trim($_GET['id']);
    $pdo = conectar();
    $departamento = buscar_departamento_por_id($id, $pdo);

    if (!$departamento) {
        return volver_departamentos();
    }

    extract($departamento);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $codigo = obtener_post('codigo');
        $denominacion = obtener_post('denominacion');
        $localidad = obtener_post('localidad');

        if (isset($codigo, $denominacion, $localidad)) {
            // Validar datos de entrada
            $errores = [];
            comprobar_codigo($codigo, $errores, $pdo, $id);
            comprobar_denominacion($denominacion, $errores);
            comprobar_localidad($localidad, $errores);
            if (empty($errores)) {
                $sent = $pdo->prepare('UPDATE departamentos
                                          SET codigo = :codigo,
                                              denominacion = :denominacion,
                                              localidad = :localidad
                                        WHERE id = :id');
                $sent->execute([
                    ':codigo' => $codigo,
                    ':denominacion' => $denominacion,
                    ':localidad' => $localidad,
                    ':id' => $id,
                ]);
                // Volver
                return volver_departamentos();
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
    <form action="" method="post">
        <label for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo"
               value="<?= $codigo ?>"><br>
        <label for="denominacion">Denominación</label>
        <input type="text" name="denominacion" id="denominacion"
               value="<?= $denominacion?>"><br>
        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" id="localidad"
               value="<?= $localidad ?>"><br>
        <button type="submit">Modificar</button>
        <a href="/departamentos/index.php">Cancelar</a>
    </form>
</body>
</html>
