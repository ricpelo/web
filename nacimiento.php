<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Cuántos años tienes?</title>
</head>
<body>
    <?php
    try {
        echo 1/0;
    } catch (DivisionByZeroError $e) {
        echo "Error: " . $e->getMessage();
    }

    const MESES = [
        1 => 'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
    ];
    $anyo_actual = (int) date('Y');

    $dia = isset($_GET['dia']) ? trim($_GET['dia']) : null;
    $mes = isset($_GET['mes']) ? trim($_GET['mes']) : null;
    $anyo = isset($_GET['anyo']) ? trim($_GET['anyo']) : null;

    if (checkdate($mes, $dia, $anyo)):
        $fecha_nac = DateTime::createFromFormat('j-n-Y', "$dia-$mes-$anyo");
        $fecha_act = new DateTime();
        $diferencia = $fecha_nac->diff($fecha_act);
    else: ?>
        <h3>Error: fecha incorrecta.</h3>
    <?php
    endif;
    ?>
    <form action="" method="get">
        <label for="dia">Fecha de nacimiento:</label>
        <select name="dia" id="dia">
            <?php for ($i = 1; $i <= 31; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
        <select name="mes" id="mes">
            <?php foreach (MESES as $m => $nombre_mes): ?>
                <option value="<?= $m ?>"><?= $nombre_mes ?></option>
            <?php endforeach ?>
        </select>
        <select name="anyo" id="anyo">
            <?php for ($i = $anyo_actual; $i >= $anyo_actual - 50; $i--): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
        <br>
        <button type="submit">Calcular</button>
    </form>
    <?php if (isset($diferencia)): ?>
        La persona tiene <?= $diferencia->y ?> años.
    <?php endif ?>
</body>
</html>
