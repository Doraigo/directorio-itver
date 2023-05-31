<?php
$conexion = new mysqli('localhost', 'root', '', 'ItverAmarillo');
if ($conexion->connect_errno) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$idProducto = $_GET['id'];

// Obtener datos del producto de la base de datos
$consultaProducto = "SELECT * FROM productos WHERE idProducto = $idProducto";
$resultadoProducto = $conexion->query($consultaProducto);
if (!$resultadoProducto) {
    die("Error al obtener los datos del producto: " . $conexion->error);
}

if ($resultadoProducto->num_rows === 0) {
    die("El producto seleccionado no existe");
}

$producto = $resultadoProducto->fetch_assoc();
$nombre = $producto['nombre'];
$precio = $producto['precio'];
$descripcion = $producto['descripcion'];
$telefono = $producto['telefono'];
$categoriaId = $producto['idCategoria'];
$imagen = $producto['imagen'];

// Obtener categorías de la base de datos
$consultaCategorias = "SELECT * FROM categorias";
$resultadoCategorias = $conexion->query($consultaCategorias);
if (!$resultadoCategorias) {
    die("Error al obtener las categorías: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1 class="titulo">Tienda en línea</h1>
    </header>
    <nav class="navegacion">
        <?php if ($resultadoCategorias->num_rows > 0): ?>
            <ul class="menu">
                <?php while ($categoria = $resultadoCategorias->fetch_assoc()): ?>
                    <li class="menu-item">
                        <a href="categoria.php?id=<?php echo $categoria['idCategoria']; ?>"><?php echo $categoria['nombreCategoria']; ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </nav>
    <main class="contenedor">
        <h1 class="titulo">Editar producto</h1>
        <form class="formulario" action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="campo">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" required>
            </div>
            <div class="campo">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo $descripcion; ?></textarea>
            </div>
            <div class="campo">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
            </div>
            <div class="campo">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <?php while ($categoria = $resultadoCategorias->fetch_assoc()): ?>
                        <option value="<?php echo $categoria['idCategoria']; ?>" <?php if ($categoria['idCategoria'] == $categoriaId) echo 'selected'; ?>><?php echo $categoria['nombreCategoria']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="campo">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
                <img src="img/productos/<?php echo $imagen; ?>" alt="Imagen del producto" class="imagen-actual">
            </div>
            <div class="campo enviar">
                <input type="submit" class="boton" value="Guardar cambios">
            </div>
        </form>
    </main>
    <footer class="footer">
        <p>Todos los derechos reservados &copy; 2023</p>
    </footer>
</body>
</html>
