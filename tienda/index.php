<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda online</title>
</head>
<body>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=tienda', 'tienda', 'tienda');
    $sent = $pdo->query('SELECT * FROM articulos');
    ?>
    <table border="1">
        <thead>
            <th>Código</th>
            <th>Denominación</th>
            <th>Precio</th>
            <th>Añadir al carrito</th>
        </thead>
        <tbody>
            <?php foreach ($sent as $fila): ?>
                <tr>
                    <td><?= $fila['codigo'] ?></td>
                    <td><?= $fila['denominacion'] ?></td>
                    <td><?= $fila['precio'] ?></td>
                    <td><a href="meter.php?id=<?= $fila['id'] ?>">Añadir al carrito</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    ?>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <h3>Carrito de la compra:</h3>
    <?php endif ?>
    <ul>
        <?php foreach ($_SESSION['carrito'] as $articulo): ?>
            <li><?= $articulo ?><a href="sacar.php?id=<?= $articulo ?>">Sacar del carrito</a></li>
        <?php endforeach ?>
    </ul>
</body>
</html>
