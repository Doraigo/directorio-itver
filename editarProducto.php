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
    <?php
    // Iniciar la sesión
    session_start();

    // Verificar si no hay una sesión activa o si no se ha almacenado la información de usuario
    if (!isset($_SESSION['username'])) {
        // Redireccionar al usuario a la página de inicio de sesión
        header("Location: login.html");
        exit;
    }

    // Obtener el idProducto desde la URL
    $idProducto = $_GET['id'];

    // Verificar si se ha proporcionado el idProducto
    if (!isset($idProducto)) {
        echo "No se ha proporcionado el ID del producto.";
        exit;
    }


    // Obtener los datos del producto desde la base de datos
    $mysqli = new mysqli("localhost", "root", "", "ItverAmarillo", 3306);

    // Verificar si hay error en la conexión
    if ($mysqli->connect_error) {
        die('Error de conexión: ' . $mysqli->connect_error);
    }

    // Consulta SQL para obtener los datos del producto
    $query = "SELECT * FROM productos WHERE idProducto = ?";
    $statement = $mysqli->prepare($query);

    // Verificar si hay error en la preparación de la consulta
    if (!$statement) {
        die('Error en la consulta: ' . $mysqli->error);
    }

    // Vincular el parámetro a la consulta preparada
    $statement->bind_param("i", $idProducto);

    // Ejecutar la consulta
    $statement->execute();

    // Obtener los resultados de la consulta
    $result = $statement->get_result();

    // Verificar si se encontró el producto
    if ($result->num_rows === 0) {
        echo "El producto no existe.";
        exit;
    }

    // Obtener los datos del producto
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $precio = $row['precio'];
    $descripcion = $row['descripcion'];
    $telefono = $row['telefono'];
    $categoriaId = $row['categoriaId'];

    // Cerrar la consulta y la conexión a la base de datos
    $statement->close();
    $mysqli->close();
    ?>

    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>
    <nav class="navegacion">
        <a class="navegacion__enlace" href="index.php">Productos</a>
        <a class="navegacion__enlace" href="nosotros.php">Nosotros</a>
    </nav>
    <h1>Editar Producto</h1>
    <div class="form__flex">
        <div class="form__contenedor">
            <form id="formulario" action="validarEditarProducto.php" method="POST" enctype="multipart/form-data">
                <div class="form__campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion"
                        required><?php echo $descripcion; ?></textarea><br><br>
                </div>
                <div class="form__campo">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" value="<?php echo $telefono; ?>"
                        required><br><br>
                </div>
                <div class="form__campo">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <?php include 'obtener_categoria.php'; ?>
                    </select><br><br>
                </div>
                <div class="form__campo">
                    <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
                    <input type="submit" value="Actualizar Producto">
                </div>
            </form>
        </div>
    </div>
    <script>
        // Agregar un evento de escucha para el envío del form
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el envío del formulario por defecto

            // Validar los campos del formulario antes de enviarlo al servidor
            const nombre = document.getElementById('nombre').value;
            const precio = document.getElementById('precio').value;
            const descripcion = document.getElementById('descripcion').value;
            const telefono = document.getElementById('telefono').value;

            if (nombre.trim() === '') {
                alert('Por favor, ingresa un nombre válido.');
                return;
            }

            if (precio.trim() === '' || isNaN(precio) || parseFloat(precio) < 0) {
                alert('Por favor, ingresa un precio válido.');
                return;
            }

            if (descripcion.trim() === '') {
                alert('Por favor, ingresa una descripción válida.');
                return;
            }

            if (telefono.trim() === '' || !telefono.match(/^\d{10}$/)) {
                alert('Por favor, ingresa un número de teléfono válido (10 dígitos).');
                return;
            }

            // Enviar el formulario al servidor si pasa las validaciones
            form.submit();
        });

    </script>
</body>

</html>