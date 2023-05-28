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
    <title>FrontEnd Store</title>
    <link rel="stylesheet" href=css/normailze.css" />
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
                    proporciona una plataforma fácil de usar y accesible para que los pequeños emprendedores tengan mas alcance 
                    y promocionen sus negocios. A lo largo del proyecto, aplicaron los principios de gestión de proyectos
                     de software para garantizar una entrega exitosa y satisfacer las necesidades de los usuarios finales.
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
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis maxime et dignissimos pariatur impedit, est, odio, animi laboriosam ea rem cupiditate commodi.
                        Veritatis dolorem possimus voluptatem, 
                            nesciunt repudiandae doloremque quo.</p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_2.png" alt="porque comprar">
                <h3 class="bloque__titulo"> Abierto a todo el Tecnologico</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis maxime et dignissimos pariatur impedit, est, odio, animi laboriosam ea rem cupiditate commodi.
                        Veritatis dolorem possimus voluptatem, 
                            nesciunt repudiandae doloremque quo.</p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_3.png" alt="porque comprar">
                <h3 class="bloque__titulo"> Exposicion</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis maxime et dignissimos pariatur impedit, est, odio, animi laboriosam ea rem cupiditate commodi.
                        Veritatis dolorem possimus voluptatem, 
                            nesciunt repudiandae doloremque quo.</p>
            </div> <!--.bloque-->

            <div class="bloque">
                <img class="bloque__imagen" src="img/icono_4.png" alt="porque comprar">
                <h3 class="bloque__titulo"> De Facil Acesso</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Perferendis maxime et dignissimos pariatur impedit, est, odio, animi laboriosam ea rem cupiditate commodi.
                        Veritatis dolorem possimus voluptatem, 
                            nesciunt repudiandae doloremque quo.</p>
            </div> <!--.bloque-->
        </div> <!--.bloques-->

    </section>

    <footer class="footer">
        <p class="footer__texto">Directorio ITVER - Todos los derechos Reservados (Equipo 2) 2023</p>
    </footer>
</body>

</html>