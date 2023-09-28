<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isograma</title>
</head>

<body>
    <?php
    function es_isograma($s)
    {
        for ($i = 0; $i < mb_strlen($s); $i++) {
            $c = mb_substr($s, $i, 1);
            if (mb_substr_count($s, $c) > 1) {
                return false;
            }
        }

        return true;
    }

    $cadena = isset($_GET['cadena']) ? trim($_GET['cadena']) : null;
    ?>
    <form action="" method="get">
        <label for="cadena">Frase a analizar:</label>
        <input type="text" name="cadena" id="cadena" value="<?= $cadena ?>"><br>
        <button type="submit">Analizar</button>
    </form>
    <?php if (isset($cadena) && $cadena !== ''): ?>
        <?php if (es_isograma($cadena)): ?>
            Sí es un isograma
        <?php else: ?>
            No es un isograma
        <?php endif ?>
    <?php endif ?>
</body>

</html>
