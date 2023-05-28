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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
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
            <a class="navegacion__enlace" href="form.php">Formulario</a>
            <a class="navegacion__enlace" href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a class="navegacion__enlace" href="login.html">Iniciar Sesión</a>
        <?php endif; ?>
    </nav>

    <main class="contenedor">
        <?php
        // Obtener el ID del producto enviado por GET
        $idProducto = $_GET['id'] ?? 0;

        // Validar que el ID sea un número entero válido
        if (!is_numeric($idProducto)) {
            echo "ID de producto inválido.";
            exit;
        }

        // Conexión a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'ItverAmarillo');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta para obtener los detalles del producto
        $sql = "SELECT p.nombre, p.precio, p.descripcion, p.imagen, cat.nombreCategoria AS categoria 
            FROM productos p
            INNER JOIN categorias cat ON p.categoriaId = cat.idCategoria
            WHERE p.idProducto = $idProducto";

        $resultado = $conexion->query($sql);

        // Verificar si se encontró el producto
        if ($resultado && $resultado->num_rows > 0) {
            $producto = $resultado->fetch_assoc();
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $descripcion = $producto['descripcion'];
            $imagen = $producto['imagen'];
            $categoria = $producto['categoria'];
            ?>



            <div class="contenedor">
                <h1>
                    <?php echo $nombre; ?>
                </h1>
                <div class="camisa">
                    <img class="camisa__imagen" src="<?php echo $imagen; ?>" alt="Imagen del Producto">
                    <p class="camisa__contenido__precio">$
                        <?php echo $precio; ?>
                    </p>
                    <p class="camisa__contenido">
                        <?php echo $descripcion; ?>
                    </p>
                    <p class="camisa__contenido__categoria">
                        <?php echo $categoria; ?>
                    </p>
                </div>
            </div>

            <?php
        } else {
            echo "No se encontró el producto.";
        }
        ?>


    </main>

    <footer class="footer">
        <p class="footer__texto">Directorio ITVER - Todos los derechos Reservados (Equipo 2) 2023</p>
    </footer>
</body>

</html>