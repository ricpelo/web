<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

function buscar_departamento_por_id($id, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }

    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE id = :id');
    $sent->execute([':id' => $id]);
    return $sent->fetch();
}

function buscar_departamento_por_codigo($codigo, ?PDO $pdo = null)
{
    if ($pdo === null) {
        $pdo = conectar();
    }

    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE codigo = :codigo');
    $sent->execute([':codigo' => $codigo]);
    return $sent->fetch();
}

function volver_departamentos()
{
    header('Location: /departamentos/index.php');
}

function volver_empleados()
{
    header('Location: /empleados/index.php');
}

function obtener_post(string $par): ?string
{
    return isset($_POST[$par]) ? trim($_POST[$par]) : null;
}

function comprobar_codigo($codigo, &$errores, ?PDO $pdo = null, $id = null)
{
    if ($codigo == '') {
        $errores[] = 'El código no puede ser vacío';
        return;
    }
    if (mb_strlen($codigo) > 2) {
        $errores[] = 'El código es demasiado largo';
    }
    if (!ctype_digit($codigo)) {
        $errores[] = 'El código tiene un formato incorrecto';
    }
    if (empty($errores)) {
        $departamento = buscar_departamento_por_codigo($codigo, $pdo);
        if ($departamento) {
            if ($id == null || ($id != null && $departamento['id'] != $id)) {
                $errores[] = 'Ya existe un departamento con ese código';
            }
        }
    }
}

function comprobar_denominacion($denominacion, &$errores)
{
    if ($denominacion == '') {
        $errores[] = 'La denominación no puede ser vacía';
        return;
    }
    if (mb_strlen($denominacion) > 255) {
        $errores[] = 'La denominación es demasiado larga';
    }
}

function comprobar_localidad(&$localidad, &$errores)
{
    if (mb_strlen($localidad) > 255) {
        $errores[] = 'La localidad es demasiado larga';
    }

    if ($localidad == '') {
        $localidad = null;
    }
}

function cabecera()
{ ?>
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Inicio</a>
                    </li>
                    <li>
                        <a href="/empleados/" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Empleados</a>
                    </li>
                    <li>
                        <a href="/departamentos/" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Departamentos</a>
                    </li>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <li><?= $_SESSION['login'] ?></li>
                        <form action="/usuarios/logout.php" method="post">
                            <button type="submit">Logout</button>
                        </form>
                    <?php else : ?>
                        <a href="/usuarios/login.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
<?php
}

function hh($cadena)
{
    return ($cadena === null)
        ? null
        : htmlspecialchars($cadena, ENT_QUOTES | ENT_SUBSTITUTE);
}

function csrf()
{
    // si la cookie está, usarla
    // si no, crearla primero
    if (isset($_COOKIE['_csrf'])) {
        $_csrf = $_COOKIE['_csrf'];
    } else {
        $_csrf = bin2hex(random_bytes(32));
        setcookie('_csrf', $_csrf);
    }

    return $_csrf;
}

function campo_csrf($_csrf = null)
{
    if ($_csrf === null) {
        $_csrf = csrf();
    }
?>
    <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
<?php
}

function validar_csrf()
{
    if (!isset($_POST['_csrf'])) {
        return false;
    }

    $_csrf = $_POST['_csrf'];

    if (!isset($_COOKIE['_csrf'])) {
        return false;
    }

    if ($_csrf != $_COOKIE['_csrf']) {
        return false;
    }

    return true;
}

function usuario_esta_logueado()
{
    return isset($_SESSION['login']);
}

function comprobar_si_logueado()
{
    if (!usuario_esta_logueado()) {
        header('Location: /usuarios/login.php');
    }
}
