<?php
/**
 * @author Ricardo Pérez <ricardo@iesdonana.org>
 * @copyright Copyright (c) 2023 Ricardo Pérez
 * @license https://www.gnu.org/licenses/gpl.txt
 */

const OPS = ['+', '-', '*', '/', '%'];

/**
 * Calcula el resultado de la operación indicada.
 *
 * @param  int|float $op1 El primer operando
 * @param  int|float $op2 El segundo operando
 * @param  int|float $op  El operador
 * @return int|float El resultado de la operación
 */
function calcular(int|float $op1, int|float $op2, string $op): int|float
{
    switch ($op) {
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
        case '%':
            $res = $op1 % $op2;
            break;
    }

    return $res;
}

/**
 * Muestra por la salida los mensajes de error de validación.
 *
 * @param  array $errores Los errores de validación (strings)
 * @return void
 */
function mostrar_errores(array $errores): void
{
    if (!empty($errores)) { ?>
        <ul>
            <?php foreach ($errores as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php
    }
}

/**
 * Comprobar el primer operando. Modifica el array de errores en caso de
 * encontrar algún error de validación.
 *
 * @param  int|float $op1     El primer operando
 * @param  array     $errores El array de errores (mutable)
 * @return void
 */
function comprobar_op1(int|float $op1, array &$errores): void
{
    if (!is_numeric($op1)) {
        $errores[] = 'El primer operando es incorrecto.';
    }
}

function comprobar_op2($op2, &$errores)
{
    if (!is_numeric($op2)) {
        $errores[] = 'El segundo operando es incorrecto.';
    }
}

function comprobar_op($op, &$errores)
{
    if (!in_array($op, OPS)) {
        $errores[] = 'La operación es incorrecta.';
    }
}

function comprobar_division_cero($op2, $op, &$errores)
{
    if ($op2 == 0 && $op == '/') {
        $errores[] = 'No se puede dividir entre cero.';
    }
}

/**
 * Muestra por la salida el resultado de la operación.
 *
 * @param  int|float $res El resultado de la operación
 * @return void
 */
function mostrar_resultado(int|float $res): void
{
    ?>
    El <strong>resultado</strong> es <strong><?= $res ?></strong>
    <?php
}

function obtener_get($par)
{
    return isset($_GET[$par]) ? trim($_GET[$par]) : null;
}

function selected($option, $op)
{
    return $option == $op ? 'selected' : '';
}
