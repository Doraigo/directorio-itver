<?php
session_start(); // Iniciar sesión

// Verificar si la página actual es form.php y no hay una sesión activa
if (basename($_SERVER['PHP_SELF']) === 'form.php' && !isset($_SESSION['username'])) {
    // Redireccionar al usuario a la página de inicio de sesión
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de alta de productos</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace" href="index.php">Productos</a>
        <a class="navegacion__enlace" href="nosotros.php">Nosotros</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a class="navegacion__enlace navegacion__enlace--activo" href="form.php">Formulario</a>
            <a class="navegacion__enlace" href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a class="navegacion__enlace" href="login.html">Iniciar Sesión</a>
        <?php endif; ?>
    </nav>


    <h1>Formulario de alta de productos</h1>
    <form action="validarForm.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required><br><br>

        <label for="descripcion">Descripcion:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" required><br><br>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php include 'obtener_categoria.php'; ?>
        </select><br><br>

        <input type="submit" value="Guardar producto">
    </form>
</body>

</html>