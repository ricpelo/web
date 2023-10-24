<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    require '../auxiliar.php';

    cabecera();

    $email = obtener_post('email');
    $password = obtener_post('password');

    if (isset($email, $password)) {
        $pdo = conectar();
        $sent = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $sent->execute(['email' => $email]);
        $fila = $sent->fetch();

        if ($fila) {
            $hash = $fila['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['login'] = $email;
                return volver_departamentos();
            }
        }

        ?>
        <h3>Credenciales incorrectas</h3>
        <?php
    }
    ?>
    <form action="" method="post">
        <label for="email">Correo electrónico:</label>
        <input type="text" name="email" id="email"><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password"><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
