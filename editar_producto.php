<?php
session_start(); // Iniciar sesión

// Verificar si la página actual es form.php y no hay una sesión activa
if (basename($_SERVER['PHP_SELF']) === 'producto.php' && !isset($_SESSION['username'])) {
    // Redireccionar al usuario a la página de inicio de sesión
    header("Location: producto.html"); 
    exit;
}
?> 


    

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicion/Baja de productos</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
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
        $sql = "SELECT p.nombre, p.precio, p.descripcion, p.imagen, p.telefono, cat.nombreCategoria AS categoria 
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
            $telefono = $producto['telefono'];
            ?>

    <h1>Edicion/Baja de productos</h1>
    <div class="form__flex">
        <div class="form__contenedor">
            <form id="formulario" action="validarEditarForm.php" method="POST" enctype="multipart/form-data">
                <div class="form__campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" value="<?php echo $precio?>" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" value="<?php echo $descripcion?>" required></textarea><br><br>
                </div>
                <div class="form__campo">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono?>" pattern="[0-9]{10}" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" value="<?php echo $imagen?>" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" value="<?php echo $categoria?>" required>
                        <?php include 'obtener_categoria.php'; ?>
                    </select><br><br>
                </div>
                <div class="form__campo">
                    <button class="vistaproducto__contactar">Actualizar producto</button>
                    <button class="vistaproducto__contactar">Eliminar producto</button>
                </div> 
            </form>
        
        </div>
    </div>
    <?php
        }  else {
            echo "No se encontró el producto.";
        }
        ?>
</body>
</html>