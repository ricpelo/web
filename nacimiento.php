<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Cuántos años tienes?</title>
</head>
<body>
    <?php
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
</body>
</html>
