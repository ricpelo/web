<?php
/**
 * @author Ricardo Pérez <ricardo@iesdonana.org>
 * @copyright Copyright (c) 2023 Ricardo Pérez
 * @license https://www.gnu.org/licenses/gpl.txt
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $op1 = obtener_get('op1');
    $op2 = obtener_get('op2');
    $op  = obtener_get('op');
    ?>

    <form action="" method="get">
        <label for="op1">Operando 1:</label>
        <input type="text" name="op1" id="op1" value="<?= $op1 ?>"><br>
        <label for="op2">Operando 2:</label>
        <input type="text" name="op2" id="op2" value="<?= $op2 ?>"><br>
        <label for="op">Operación:</label>
        <select name="op" id="op">
            <?php foreach (OPS as $oper): ?>
                <option value="<?= $oper ?>" <?= selected($oper, $op) ?>>
                    <?= $oper ?>
                </option>
            <?php endforeach ?>
        </select><br>
        <button type="submit">Calcular</button>
    </form>

    <?php
    $errores = [];

    if (isset($op1, $op2, $op)) {
        comprobar_op1($op1, $errores);
        comprobar_op2($op2, $errores);
        comprobar_op($op, $errores);
        comprobar_division_cero($op2, $op, $errores);
        if (empty($errores)) {
            $res = calcular($op1, $op2, $op);
            mostrar_resultado($res);
        } else {
            mostrar_errores($errores);
        }
    }
    ?>
</body>

</html>
