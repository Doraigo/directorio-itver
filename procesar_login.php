<?php
// Datos de la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$baseDatos = 'ItverAmarillo';

// Obtener los datos enviados por el formulario
$nombreUsuario = $_POST['username'];
$contrasenaUsuario = $_POST['password'];

// Crear conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $baseDatos,"3306");

// Verificar si hay error en la conexión
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Consulta SQL para verificar el usuario y la contraseña
$sql = "SELECT * FROM usuarios WHERE nombreUsuario = '$nombreUsuario' AND contrasena = '$contrasenaUsuario'";
$resultado = $conexion->query($sql);

// Verificar si se encontró un resultado
if ($resultado->num_rows > 0) {
    // El usuario y la contraseña son correctos
    $_SESSION['username'] = $nombreUsuario;
    header('Location: form.php');
    exit;
} else {
    // El usuario y/o la contraseña son incorrectos
    echo 'Usuario o contraseña incorrectos';
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
