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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sobre Nosotros</title>
    <link rel="stylesheet" href=css/normalize.css />
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
        <a class="navegacion__enlace navegacion__enlace--activo" href="nosotros.php">Nosotros</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a class="navegacion__enlace" href="form.php">Formulario</a>
            <a class="navegacion__enlace" href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a class="navegacion__enlace" href="login.html">Iniciar Sesión</a>
        <?php endif; ?>
    </nav>

    <main class="contenedor">
        <h1> Sobre Nosotros</h1>
        <div class="nosotros">
            <div class="nosotros__contenido">
                <p>En resumen, el equipo de desarrolladores trabajó en conjunto para crear una página web que
                    proporciona una plataforma fácil de usar y accesible para que los pequeños emprendedores tengan mas
                    alcance
                    y promocionen sus negocios. A lo largo del proyecto, aplicaron los principios de gestión de
                    proyectos
                    de software para garantizar una entrega exitosa y satisfacer las necesidades de los usuarios
                    finales.
                </p>

            </div>
            <img class="nosotros__imagen" src="img/nosotros.jpg" alt="nosotros">
        </div>
    </main>

    <section class="contenedor comprar">
        <h2 class="comprar__titutlo"> ¿Por que usar esta pagina?</h2>

        <div class="bloques">
            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_1.png" alt="porque comprar">
                <h3 class="bloque__titulo"> Sencillez</h3>
                <p>Fue diseñado de manera que sea sencillo al ingresar a la pagina principal
                    ya se esta mostrando productos para poder beneficiar a los vendedores.
                </p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_2.png" alt="porque comprar">
                <h3 class="bloque__titulo"> Abierto a todo el Tecnologico</h3>
                <p>Cualquier alumno puede acceder por medio de la URL que tiene nuestro sitio asi que esta a un solo
                    click para poder acceder.
                </p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_3.png" alt="porque comprar">
                <h3 class="bloque__titulo"> Exposicion</h3>
                <p>Al no estar limitado como el grupo de whatsapp en cuanto a integrantes toda persona puede ingresar y
                    visualizar
                    todos los productos de cualquier vendedor del tecnologico.
                </p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_4.png" alt="porque comprar">
                <h3 class="bloque__titulo"> De Facil Acesso</h3>
                <p>Tanto para vendedores, como para estudiantes es super sencillo el acceder y comunicarse por el medio
                    que el
                    vendedor prefiera ya que podra asignar el metodo que prefiera en su producto.
                </p>
            </div> <!--.bloque-->
        </div> <!--.bloques-->

    </section>

    <footer class="footer">
        <button id="contactarBtn" class="boton-contactar">Contactar</button>
        <p class="footer__texto">Directorio ITVER - Todos los derechos Reservados (Equipo 2) 2023</p>
    </footer>

    <script>
        document.getElementById('contactarBtn').addEventListener('click', function () {
            window.location.href = 'mailto:directorioitver1@gmail.com';
        });
    </script>
</body>

</html>