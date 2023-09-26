<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>

<body>
    <?php
    $errores = [];

    if (isset($_GET['op1'])) {
        $op1 = $_GET['op1'];
        if (!is_numeric($op1)) {
            $errores[] = 'El primer operando es incorrecto.';
        }
    } else {
        $errores[] = 'Falta el primer operando.';
    }

    if (isset($_GET['op2'])) {
        $op2 = $_GET['op2'];
        if (!is_numeric($op2)) {
            $errores[] = 'El segundo operando es incorrecto.';
        }
    } else {
        $errores[] = 'Falta el segundo operando.';
    }

    if (isset($_GET['op'])) {
        $op = $_GET['op'];
        if (!in_array($op, ['+', '-', '*', '/'])) {
            $errores[] = 'La operación es incorrecta.';
        }
    } else {
        $errores[] = 'Falta la operación.';
    }

    if (empty($errores)):
        switch ($op):
            case '+':
                $res = $op1 + $op2;
                break;
            case '-':
                $res = $op1 - $op2;
                break;
            case '*':
                $res = $op1 * $op2;
                break;
            case '/':
                $res = $op1 / $op2;
                break;
        endswitch
        ?>
        El <strong>resultado</strong> es <strong><?= $res ?></strong>
    <?php else: ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
</body>

</html>
