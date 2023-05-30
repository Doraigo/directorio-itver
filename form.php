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
    <div class="form__flex">
        <div class="form__contenedor">
            <form id="formulario" action="validarForm.php" method="POST" enctype="multipart/form-data">
                <div class="form__campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" required><br><br>
                </div>
                <div class="form__campo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea><br><br>
                </div>
                <div class="form__campo">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" required><br><br>
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
                    <input type="submit" value="Guardar producto">
                </div>
            </form>
        </div>
    </div>
    <script>
        // Obtener el formulario
        const form = document.getElementById('formulario');

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